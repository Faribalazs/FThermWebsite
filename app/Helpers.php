<?php

if (!function_exists('translate')) {
    /**
     * Get translated value from multilingual JSON field
     * 
     * @param array|string|null $value
     * @param string|null $locale
     * @return string
     */
    function translate($value, ?string $locale = null): string
    {
        if (is_string($value)) {
            return $value;
        }
        
        if (!is_array($value)) {
            return '';
        }
        
        $locale = $locale ?? app()->getLocale();
        
        return $value[$locale] ?? $value['en'] ?? $value['sr'] ?? '';
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get current locale
     * 
     * @return string
     */
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('change_locale_url')) {
    /**
     * Generate URL with different locale
     * 
     * @param string $locale
     * @return string
     */
    function change_locale_url(string $locale): string
    {
        return url()->current() . '?lang=' . $locale;
    }
}
