<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    /** @test */
    public function login_with_correct_credentials(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }

    /** @test */
    public function login_fails_with_invalid_email_format(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'invalid-email',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function login_fails_with_incorrect_password(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The provided credentials are incorrect.'
        ]);
    }

    /** @test */
    public function login_fails_with_missing_email_or_password(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'test@example.com',
            // Password is missing
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

}
