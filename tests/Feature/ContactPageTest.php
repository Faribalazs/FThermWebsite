<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('locales')]
    public function test_contact_page_and_footer_show_saved_company_details_in_each_language(string $locale, string $heading): void
    {
        $details = [
            'company_name' => 'Test Company PR',
            'company_address' => 'Test Street 8, Subotica',
            'company_pib' => '123456789',
            'company_maticni_broj' => '87654321',
            'company_sifra_delatnosti' => '4322',
            'company_bank_account' => '165-1234567890-11',
            'company_phone' => '+381 64 123 4567',
            'company_email' => 'contact@example.test',
        ];
        foreach ($details as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $url = url('/'.$locale.'/contact');
        $response = $this->get($url)->assertOk()
            ->assertSee($heading)
            ->assertSee('href="'.$url.'"', false)
            ->assertSee('action="'.$url.'"', false)
            ->assertSee('href="tel:+381641234567"', false)
            ->assertSee('href="mailto:contact@example.test"', false)
            ->assertSee('rel="canonical" href="'.$url.'"', false)
            ->assertSee('aria-current="page"', false)
            ->assertDontSee('ftherm.company.');

        [$main, $footer] = explode('<footer', $response->getContent(), 2);
        foreach ($details as $key => $value) {
            $this->assertStringContainsString($value, $main);
            if (in_array($key, ['company_name', 'company_address'], true)) {
                $this->assertStringNotContainsString($value, $footer);
            } else {
                $this->assertStringContainsString($value, $footer);
            }
        }
        // Desktop navigation, mobile navigation and footer all lead to this page.
        $document = new \DOMDocument;
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        foreach (['site-nav-link', 'site-mobile-nav-link'] as $class) {
            $this->assertSame(1, $xpath->query('//a[@href="'.$url.'" and contains(@class, "'.$class.'")]')->length);
        }
        $this->assertSame(1, $xpath->query('//footer//a[@href="'.$url.'"]')->length);
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public static function locales(): array
    {
        return [['sr', 'Javite nam se'], ['en', 'Get in touch'], ['hu', 'Lépjen kapcsolatba velünk']];
    }

    public function test_company_changes_are_visible_on_the_next_request_and_missing_details_are_omitted(): void
    {
        Setting::create(['key' => 'company_pib', 'value' => '123456789']);
        $this->get('/sr/contact')->assertOk()->assertSee('123456789');

        Setting::where('key', 'company_pib')->update(['value' => '987654321']);
        $this->get('/sr/contact')->assertOk()->assertSee('987654321')->assertDontSee('123456789');
        // The same live value is used by the footer on other public pages.
        $this->get('/sr')->assertOk()->assertSee('987654321');

        Setting::where('key', 'company_pib')->delete();
        $this->get('/sr/contact')->assertOk()->assertDontSee('987654321')
            ->assertDontSee('company-details__heading', false);
    }

    public function test_contact_alias_language_links_and_sitemap_resolve_to_the_new_page(): void
    {
        foreach (['sr', 'en', 'hu'] as $locale) {
            $this->get('/'.$locale.'/kontakt')->assertStatus(301)->assertRedirect('/'.$locale.'/contact');
        }
        $this->get('/sr/contact')->assertSee('href="'.url('/en/contact').'"', false)
            ->assertSee('href="'.url('/hu/contact').'"', false);
        $this->get('/sitemap.xml')->assertOk()->assertSee('/sr/contact', false)
            ->assertSee('/en/contact', false)->assertSee('/hu/contact', false);
        $this->get('/llms.txt')->assertOk()->assertSee('/sr/contact', false);
    }

    public function test_contact_form_keeps_validation_and_submits_to_the_existing_inquiry_flow(): void
    {
        Mail::fake();
        Setting::create(['key' => 'inquiry_notification_email', 'value' => 'team@example.test']);

        $this->from('/sr/contact')->post('/sr/contact', ['name' => 'Test visitor'])
            ->assertRedirect('/sr/contact')->assertSessionHasErrors(['phone', 'message']);
        $this->assertDatabaseCount('inquiries', 0);
        $this->get('/sr/contact')->assertOk()->assertSee('value="Test visitor"', false);

        $this->from('/sr/contact')->post('/sr/contact', [
            'name' => 'Test visitor', 'phone' => '0641234567', 'email' => 'visitor@example.test',
            'city' => 'Subotica', 'service_type' => 'heat_pump', 'message' => 'Please send a quote.',
        ])->assertRedirect('/sr/contact')->assertSessionHasNoErrors()->assertSessionHas('contact_success');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Test visitor', 'email' => 'visitor@example.test', 'service_type' => 'heat_pump',
        ]);
        $this->get('/sr/contact')->assertOk()->assertSee('role="status"', false)->assertSee('Hvala! Primili smo vašu poruku');
        $this->assertSame(1, Inquiry::count());
    }

    public function test_new_contact_page_participates_in_filtered_page_view_tracking(): void
    {
        $this->get('/sr/contact', ['User-Agent' => 'Mozilla/5.0 Chrome/141.0.0.0 Safari/537.36'])->assertOk();
        $this->assertDatabaseHas('page_views', ['path' => '/sr/contact', 'route_name' => 'contact']);
        $this->get('/sr/contact', ['User-Agent' => 'Googlebot/2.1'])->assertOk();
        $this->assertDatabaseCount('page_views', 1);
    }
}
