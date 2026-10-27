<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSeoRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_disabled_catalog_returns_a_helpful_gone_response_for_catalog_and_stale_products(): void
    {
        Setting::updateOrCreate(['key' => 'shop_enabled'], ['value' => 'false']);

        $this->get('/sr/shop')
            ->assertStatus(410)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->assertSee('Katalog proizvoda trenutno nije dostupan');

        $this->get('/sr/shop/product-that-no-longer-exists')
            ->assertStatus(410)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->assertSee('Pogledajte usluge');
    }

    public function test_enabled_catalog_resolves_public_products_by_slug_and_hides_inactive_products(): void
    {
        Setting::updateOrCreate(['key' => 'shop_enabled'], ['value' => 'true']);

        $activeProduct = Product::create([
            'name' => ['sr' => 'Aktivan proizvod', 'en' => 'Active product', 'hu' => 'Aktív termék'],
            'description' => ['sr' => 'Opis', 'en' => 'Description', 'hu' => 'Leírás'],
            'slug' => 'active-product',
            'active' => true,
        ]);

        Product::create([
            'name' => ['sr' => 'Neaktivan proizvod', 'en' => 'Inactive product', 'hu' => 'Inaktív termék'],
            'description' => ['sr' => 'Opis', 'en' => 'Description', 'hu' => 'Leírás'],
            'slug' => 'inactive-product',
            'active' => false,
        ]);

        $this->get('/sr/shop/'.$activeProduct->slug)
            ->assertOk()
            ->assertSee('Aktivan proizvod');

        $this->get('/sr/shop/inactive-product')->assertNotFound();
    }

    public function test_disabled_catalog_is_absent_from_sitemap_while_local_pages_remain_discoverable(): void
    {
        Setting::updateOrCreate(['key' => 'shop_enabled'], ['value' => 'false']);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertDontSee('/shop', false)
            ->assertSee('/sr/klime-subotica', false)
            ->assertSee('/sr/toplotne-pumpe-subotica', false);
    }

    public function test_heat_pump_local_page_is_linked_from_public_navigation_and_footer(): void
    {
        $response = $this->get('/sr/toplotne-pumpe-subotica');

        $response
            ->assertOk()
            ->assertSee('Toplotne pumpe i profesionalna ugradnja u Subotici')
            ->assertSee('site-nav-services__menu', false)
            ->assertSee(route('local-seo.heat-pumps', ['locale' => 'sr']), false);

        $this->assertGreaterThanOrEqual(
            3,
            substr_count($response->getContent(), route('local-seo.heat-pumps', ['locale' => 'sr']))
        );
    }
}
