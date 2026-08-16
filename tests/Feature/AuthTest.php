<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_reachable_by_guests(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_guests_are_redirected_to_login_from_protected_pages(): void
    {
        foreach (['/student', '/add-student', '/scanner'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_user_can_log_in_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('students.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_reach_protected_pages_and_log_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/student')->assertStatus(200);
        $this->actingAs($user)->get('/scanner')->assertStatus(200);

        $this->actingAs($user)->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }
}
