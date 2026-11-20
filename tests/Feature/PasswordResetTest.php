<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_is_available_from_login(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('password.request'), false);

        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee(route('password.request'), false);

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('পাসওয়ার্ড ভুলে গেছেন', false);
    }

    public function test_reset_link_can_be_requested_with_email(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'username' => 'resetuser',
            'mobile' => '01711112222',
            'role' => 'student',
            'is_active' => true,
        ]);

        $this->from(route('password.request'))
            ->post(route('password.email'), ['login' => $user->email])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('success');

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_reset_link_can_be_requested_with_username(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'username' => 'resetbyname',
            'mobile' => '01711113333',
            'role' => 'student',
            'is_active' => true,
        ]);

        $this->from(route('password.request'))
            ->post(route('password.email'), ['login' => 'resetbyname'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('success');

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'username' => 'newpassuser',
            'role' => 'student',
            'is_active' => true,
            'password' => 'old-password',
        ]);

        $this->post(route('password.email'), ['login' => $user->email]);

        Notification::assertSentTo($user, ResetPasswordNotification::class, function (ResetPasswordNotification $notification) use ($user) {
            $this->get(route('password.reset', [
                'token' => $notification->token,
                'email' => $user->email,
            ]))->assertOk();

            $this->from(route('password.reset', ['token' => $notification->token]))
                ->post(route('password.update'), [
                    'token' => $notification->token,
                    'email' => $user->email,
                    'password' => 'new-password',
                    'password_confirmation' => 'new-password',
                ])
                ->assertRedirect(route('login'))
                ->assertSessionHas('success');

            $this->assertTrue(Hash::check('new-password', $user->fresh()->password));

            return true;
        });
    }

    public function test_unknown_login_still_shows_success_without_sending_mail(): void
    {
        Notification::fake();

        $this->from(route('password.request'))
            ->post(route('password.email'), ['login' => 'nobody@example.com'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('success');

        Notification::assertNothingSent();
    }
}
