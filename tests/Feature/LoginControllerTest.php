<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\Entities\User;

class LoginControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }
    /**
     * @test
     */
    public function itShouldValidateFields()
    {
        $response = $this->json('POST', '/api/v1/login');
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.'
        ]);
    }

    /**
     * @test
     */
    public function itShouldValidateEmail()
    {
        $response = $this->json('POST', '/api/v1/login', [
            'email' => 'invalid_email',
            'password' => '123'
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'The email must be a valid email address.',
        ]);
    }


    /**
     * @test
     */
    public function itShouldValidatePasswordLength()
    {
        $response = $this->json('POST', '/api/v1/login', [
            'email' => 'invalid_email',
            'password' => '123'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'password' => 'The password must be at least 6 characters.',
        ]);
    }

    /**
     * @test
     */
    public function itShouldLogin()
    {
        $response = $this->json('POST', '/api/v1/login', [
            'email' => 'marcelo.nakash@gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'access_token' => 'bWFyY2Vsby5uYWthc2hAZ21haWwuY29t'
        ]);
    }

    /**
     * @test
     */
    public function itShouldReturnUser()
    {
        $user = new User('marcelo.nakash@gmail.com', 'Marcelo Nakashima', 123);

        $response = $this->json('GET', '/api/v1/user', [], [
            'Authorization' => 'Bearer bWFyY2Vsby5uYWthc2hAZ21haWwuY29t'
        ]);
        $response->assertStatus(200);
        $response->assertJson($user->jsonSerialize());
    }

    /**
     * @test
     */
    public function itShouldReturn401()
    {
        $response = $this->json('GET', '/api/v1/user');
        $response->assertStatus(401);
    }
}
