<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CompanySearchService
{
    /**
     * APR (Agencija za privredne registre) API base URL.
     */
    protected string $apiBaseUrl = 'https://pretraga.apr.gov.rs/api';

    /**
     * Search for Serbian companies by name or matični broj.
     *
     * @param string $query  The search term (company name or matični broj)
     * @param string $recaptchaToken  reCAPTCHA v3 token from frontend
     * @return array  ['success' => bool, 'data' => array, 'error' => string|null]
     */
    public function search(string $query, string $recaptchaToken): array
    {
        try {
            // Determine if query is a matični broj (all digits, 8 chars) or company name
            $isMaticniBroj = preg_match('/^\d{7,8}$/', trim($query));
            $isPib = preg_match('/^\d{9}$/', trim($query));

            $params = [
                'matNumber' => $isMaticniBroj ? trim($query) : '',
                'name' => (!$isMaticniBroj && !$isPib) ? trim($query) : '',
                'register' => '',
                'status' => '',
                'recaptchaToken' => $recaptchaToken,
            ];

            // If it's a PIB (9 digits), we search by name (APR doesn't have direct PIB search in unified)
            // We'll filter results client-side or try matNumber field
            if ($isPib) {
                $params['matNumber'] = '';
                $params['name'] = trim($query);
            }

            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Accept' => 'application/json',
                'Referer' => 'https://pretraga.apr.gov.rs/search',
                'Origin' => 'https://pretraga.apr.gov.rs',
            ])->timeout(10)->get($this->apiBaseUrl . '/search', $params);

            if ($response->failed()) {
                Log::warning('CompanySearch: APR API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'data' => [],
                    'error' => 'Pretraga trenutno nije dostupna. Pokušajte ponovo kasnije.',
                ];
            }

            $data = $response->json();

            // Check for reCAPTCHA errors
            if (isset($data['message']['error'])) {
                return [
                    'success' => false,
                    'data' => [],
                    'error' => 'Verifikacija nije uspela. Pokušajte ponovo.',
                ];
            }

            // Parse and normalize results
            $results = $this->parseResults($data);

            return [
                'success' => true,
                'data' => $results,
                'error' => null,
            ];
        } catch (\Exception $e) {
            Log::error('CompanySearch: Exception during search', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'data' => [],
                'error' => 'Greška pri pretrazi. Pokušajte ponovo.',
            ];
        }
    }

    /**
     * Parse APR search results into a normalized format.
     */
    protected function parseResults(array $data): array
    {
        $results = [];

        // The APR API returns results in "message" field when successful
        $items = $data['message'] ?? $data['data'] ?? $data;

        if (!is_array($items)) {
            return [];
        }

        // If the response is a direct array of items
        if (isset($items[0]) || (is_array($items) && !isset($items['error']))) {
            foreach ($items as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $result = [
                    'company_name' => $item['CurrentBusinessName'] ?? $item['BusinessName'] ?? $item['name'] ?? '',
                    'maticni_broj' => $item['RegistryCode'] ?? $item['MaticniBroj'] ?? $item['matNumber'] ?? '',
                    'pib' => $item['TaxNumber'] ?? $item['PIB'] ?? $item['pib'] ?? '',
                    'status' => $item['CurrentStatusName'] ?? $item['Status'] ?? '',
                    'register' => $item['RegisterTypeName'] ?? $item['Register'] ?? '',
                    'address' => $this->formatAddress($item),
                ];

                // Only add if we have at least a company name
                if (!empty($result['company_name'])) {
                    $results[] = $result;
                }
            }
        }

        return array_slice($results, 0, 20); // Limit to 20 results
    }

    /**
     * Format address from various possible address fields.
     */
    protected function formatAddress(array $item): string
    {
        $parts = [];

        if (!empty($item['AddressStreet'])) {
            $street = $item['AddressStreet'];
            if (!empty($item['AddressNumber'])) {
                $street .= ' ' . $item['AddressNumber'];
            }
            $parts[] = $street;
        }

        if (!empty($item['PlaceName'])) {
            $parts[] = $item['PlaceName'];
        } elseif (!empty($item['MunicipalityName'])) {
            $parts[] = $item['MunicipalityName'];
        }

        if (!empty($item['Address'])) {
            return $item['Address'];
        }

        return implode(', ', $parts);
    }
}
