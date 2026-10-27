<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Database\Seeders\CompanySettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogDefaultsTest extends TestCase
{
    use RefreshDatabase;

    public function test_fresh_migrations_disable_the_catalog_and_hide_public_links(): void
    {
        $this->assertSame('false', Setting::where('key', 'shop_enabled')->value('value'));
        $this->get('/sr')->assertOk()->assertDontSee('href="'.url('/sr/shop').'"', false);
        $this->get('/sr/shop')->assertGone();
        $this->get('/sitemap.xml')->assertOk()->assertDontSee('/shop', false);
    }

    public function test_missing_or_invalid_settings_are_off_in_both_public_and_admin_views(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'role' => 'admin']), 'admin');

        foreach ([null, '', 'unexpected'] as $value) {
            Setting::where('key', 'shop_enabled')->delete();
            if ($value !== null) {
                Setting::create(['key' => 'shop_enabled', 'value' => $value]);
            }

            $this->get('/sr/shop')->assertGone();
            $this->get(route('admin.catalog-settings.index'))->assertOk()->assertViewHas('shopEnabled', false);
        }
    }

    public function test_seeder_defaults_to_off_and_preserves_a_later_admin_choice(): void
    {
        Setting::where('key', 'shop_enabled')->delete();
        $this->seed(CompanySettingsSeeder::class);
        $this->assertSame('false', Setting::where('key', 'shop_enabled')->value('value'));

        $this->actingAs(User::factory()->create(['is_admin' => true, 'role' => 'admin']), 'admin');
        $this->post(route('admin.catalog-settings.update'), ['shop_enabled' => 'true'])
            ->assertRedirect()->assertSessionHasNoErrors();
        $this->seed(CompanySettingsSeeder::class);

        $this->assertSame('true', Setting::where('key', 'shop_enabled')->value('value'));
        $this->get('/sr/shop')->assertOk();
        $this->get(route('admin.catalog-settings.index'))->assertViewHas('shopEnabled', true);
    }

    public function test_upgrade_migration_disables_existing_catalog_without_changing_other_settings(): void
    {
        Setting::where('key', 'shop_enabled')->update(['value' => 'true']);
        Setting::create(['key' => 'company_name', 'value' => 'Keep this company']);

        $migration = require database_path('migrations/2026_10_27_170000_disable_public_catalog_by_default.php');
        $migration->up();

        $this->assertSame('false', Setting::where('key', 'shop_enabled')->value('value'));
        $this->assertSame('Keep this company', Setting::where('key', 'company_name')->value('value'));
        $migration->down();
        $this->assertSame('false', Setting::where('key', 'shop_enabled')->value('value'));
    }
}
