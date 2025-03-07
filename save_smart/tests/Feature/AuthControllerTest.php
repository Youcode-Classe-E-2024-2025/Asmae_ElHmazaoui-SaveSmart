<?php

namespace Tests\Feature;

use App\Models\FamilyAccount;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_shows_the_signup_page()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('signup');
    }

    /** @test */
    public function it_shows_the_login_page()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    /** @test */
    public function it_registers_a_new_user()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'Password123@',
            'password_confirmation' => 'Password123@',
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect(route('FamilyAccount.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
        $this->assertAuthenticated();
    }

    /** @test */
    public function it_registers_a_new_user_with_invitation()
    {
        // Create an inviter user
        $inviter = User::factory()->create();

        // Create a family account
        $familyAccount = FamilyAccount::factory()->create();

        // Create an invitation
        $invitation = Invitation::create([
            'family_account_id' => $familyAccount->id,
            'email' => $this->faker->unique()->safeEmail,
            'token' => uniqid(),
            'invited_by' => $inviter->id,
        ]);

        // Put the invitation token in the session
        session(['invitation_token' => $invitation->token]);

        // User data for registration
        $userData = [
            'name' => $this->faker->name,
            'email' => $invitation->email,
            'password' => 'Password123@',
            'password_confirmation' => 'Password123@',
        ];

        // Simulate the registration request
        $response = $this->post(route('register'), $userData);

        // Assertions
        $response->assertRedirect(route('FamilyAccount.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', ['email' => $userData['email'], 'family_account_id' => $familyAccount->id]);
        $this->assertDatabaseMissing('invitations', ['token' => $invitation->token]);
        $this->assertAuthenticated();
        $this->assertNull(session('invitation_token'));
    }

    /** @test */
    public function it_fails_registration_due_to_validation_errors()
    {
        $userData = [
            'name' => '', // Empty name to cause validation error
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest(); // Assert that the user is not authenticated
    }

    /** @test */
    public function it_logs_in_an_existing_user()
    {
        // Create a user
        $user = User::factory()->create([
            'password' => Hash::make('Password123@'), // Hash the password
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'Password123@',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertRedirect(route('FamilyAccount.index'));
        $response->assertSessionHas('success');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_logs_in_an_existing_user_with_invitation()
    {
        // Create an inviter user
        $inviter = User::factory()->create();

        // Create a family account
        $familyAccount = FamilyAccount::factory()->create();

        // Create an invitation
        $invitation = Invitation::create([
            'family_account_id' => $familyAccount->id,
            'email' => 'test@example.com',
            'token' => uniqid(),
            'invited_by' => $inviter->id,
        ]);

        // Put the invitation token in the session
        session(['invitation_token' => $invitation->token]);

        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123@'), // Hash the password
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'Password123@',
        ];

        // Simulate the registration request
        $response = $this->post(route('login'), $credentials);

        // Assertions
        $response->assertRedirect(route('FamilyAccount.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', ['email' => $user->email, 'family_account_id' => $familyAccount->id]);
        $this->assertDatabaseMissing('invitations', ['token' => $invitation->token]);
        $this->assertAuthenticated();
        $this->assertNull(session('invitation_token'));
    }

    /** @test */
    public function it_fails_login_due_to_invalid_credentials()
    {
        $credentials = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function it_logs_out_a_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // Authenticate the user

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertGuest();
    }
}