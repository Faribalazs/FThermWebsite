<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccountSettingsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_admin' => true, 'is_active' => true]);
    }

    public function test_settings_show_the_signed_in_admin_account_and_separate_forms(): void
    {
        $admin = $this->admin();
        $worker = User::factory()->create(['role' => 'worker']);

        $this->actingAs($worker, 'worker')->actingAs($admin, 'admin')
            ->get(route('admin.settings.index'))->assertOk()
            ->assertSee('Administratorski nalog')
            ->assertSee('value="'.$admin->email.'"', false)
            ->assertDontSee($worker->email)
            ->assertSee('action="'.route('admin.settings.email.update').'"', false)
            ->assertSee('action="'.route('admin.settings.password.update').'"', false)
            ->assertSee('Režim održavanja');
    }

    public function test_guests_and_workers_cannot_access_admin_account_settings(): void
    {
        $this->get(route('admin.settings.index'))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.settings.email.update'), [])->assertRedirect(route('admin.login'));
        $this->put(route('admin.settings.password.update'), [])->assertRedirect(route('admin.login'));

        $worker = User::factory()->create(['role' => 'worker', 'is_admin' => false]);
        $this->actingAs($worker, 'worker');
        $this->get(route('admin.settings.index'))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.settings.email.update'), [])->assertRedirect(route('admin.login'));
        $this->put(route('admin.settings.password.update'), [])->assertRedirect(route('admin.login'));

        $this->actingAs($worker, 'admin');
        $this->get(route('admin.settings.index'))->assertForbidden();
        $this->patch(route('admin.settings.email.update'), [])->assertForbidden();
        $this->put(route('admin.settings.password.update'), [])->assertForbidden();
    }

    public function test_email_change_updates_only_the_authenticated_admin_and_supports_next_login(): void
    {
        $admin = $this->admin();
        $other = $this->admin();
        $oldEmail = $admin->email;
        $oldPassword = $admin->password;
        $oldRememberToken = $admin->remember_token;
        Setting::create(['key' => 'inquiry_notification_email', 'value' => 'notifications@example.test']);

        $this->actingAs($other, 'worker')->actingAs($admin, 'admin')
            ->patch(route('admin.settings.email.update'), [
                'email' => 'new-admin@example.test', 'current_password' => 'password',
                'id' => $other->id, 'role' => 'worker', 'maintenance_mode' => 'true',
                'inquiry_notification_email' => 'changed@example.test',
            ])->assertRedirect(route('admin.settings.index'))->assertSessionHasNoErrors()->assertSessionHas('success');

        $admin->refresh();
        $this->assertSame('new-admin@example.test', $admin->email);
        $this->assertNull($admin->email_verified_at);
        $this->assertSame('admin', $admin->role);
        $this->assertSame($oldPassword, $admin->password);
        $this->assertNotSame($oldRememberToken, $admin->remember_token);
        $this->assertSame($other->email, $other->fresh()->email);
        $this->assertSame('notifications@example.test', Setting::where('key', 'inquiry_notification_email')->value('value'));
        $this->assertNotSame('true', Setting::where('key', 'maintenance_mode')->value('value'));
        $this->assertAuthenticatedAs($admin, 'admin');

        $this->post(route('admin.logout'));
        $this->post(route('admin.login'), ['email' => $oldEmail, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest('admin');
        $this->post(route('admin.login'), ['email' => $admin->email, 'password' => 'password'])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_email_change_rejects_wrong_password_invalid_email_and_duplicate_email(): void
    {
        $admin = $this->admin();
        $other = User::factory()->create();
        $this->actingAs($admin, 'admin');

        foreach ([
            ['email' => 'new@example.test', 'current_password' => 'wrong-password', 'error' => 'current_password'],
            ['email' => 'invalid', 'current_password' => 'password', 'error' => 'email'],
            ['email' => $other->email, 'current_password' => 'password', 'error' => 'email'],
        ] as $case) {
            $this->from(route('admin.settings.index'))
                ->patch(route('admin.settings.email.update'), $case)
                ->assertRedirect(route('admin.settings.index'))
                ->assertSessionHasErrorsIn('adminEmail', $case['error'])
                ->assertSessionMissing('_old_input.current_password');
            $this->assertSame($admin->email, $admin->fresh()->email);
        }
    }

    public function test_saving_an_unchanged_email_preserves_verification(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin, 'admin')->patch(route('admin.settings.email.update'), [
            'email' => $admin->email, 'current_password' => 'password',
        ])->assertSessionHasNoErrors();

        $this->assertEquals($admin->email_verified_at, $admin->fresh()->email_verified_at);
        $this->assertSame($admin->remember_token, $admin->fresh()->remember_token);
    }

    public function test_password_change_is_hashed_and_new_credentials_work(): void
    {
        $admin = $this->admin();
        $other = $this->admin();
        $oldRememberToken = $admin->remember_token;

        $this->actingAs($other, 'worker')->actingAs($admin, 'admin')
            ->put(route('admin.settings.password.update'), [
                'current_password' => 'password', 'password' => 'new-admin-password',
                'password_confirmation' => 'new-admin-password', 'id' => $other->id,
            ])->assertRedirect(route('admin.settings.index'))->assertSessionHasNoErrors()->assertSessionHas('success');

        $admin->refresh();
        $this->assertTrue(Hash::check('new-admin-password', $admin->password));
        $this->assertFalse(Hash::check('password', $admin->password));
        $this->assertNotSame($oldRememberToken, $admin->remember_token);
        $this->assertTrue(Hash::check('password', $other->fresh()->password));
        $this->assertAuthenticatedAs($admin, 'admin');

        $this->post(route('admin.logout'));
        $this->post(route('admin.login'), ['email' => $admin->email, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest('admin');
        $this->post(route('admin.login'), ['email' => $admin->email, 'password' => 'new-admin-password'])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_password_changes_require_the_correct_admin_password_and_matching_strong_confirmation(): void
    {
        $admin = $this->admin();
        $worker = User::factory()->create(['password' => 'worker-password']);
        $this->actingAs($worker, 'worker')->actingAs($admin, 'admin');

        foreach ([
            ['current_password' => 'worker-password', 'password' => 'new-password', 'password_confirmation' => 'new-password', 'error' => 'current_password'],
            ['current_password' => 'password', 'password' => 'new-password', 'password_confirmation' => 'mismatched-password', 'error' => 'password'],
            ['current_password' => 'password', 'password' => 'short', 'password_confirmation' => 'short', 'error' => 'password'],
            ['current_password' => 'password', 'password' => 'password', 'password_confirmation' => 'password', 'error' => 'password'],
        ] as $case) {
            $this->from(route('admin.settings.index'))
                ->put(route('admin.settings.password.update'), $case)
                ->assertRedirect(route('admin.settings.index'))
                ->assertSessionHasErrorsIn('adminPassword', $case['error'])
                ->assertSessionMissing('_old_input.current_password')
                ->assertSessionMissing('_old_input.password')
                ->assertSessionMissing('_old_input.password_confirmation');
            $this->assertTrue(Hash::check('password', $admin->fresh()->password));
        }
    }

    public function test_account_changes_limit_repeated_password_guesses(): void
    {
        $this->actingAs($this->admin(), 'admin');
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->patch(route('admin.settings.email.update'), [
                'email' => 'new-admin@example.test', 'current_password' => 'wrong-password',
            ])->assertSessionHasErrorsIn('adminEmail', 'current_password');
        }
        $this->patch(route('admin.settings.email.update'), [
            'email' => 'new-admin@example.test', 'current_password' => 'wrong-password',
        ])->assertTooManyRequests();
    }
}
