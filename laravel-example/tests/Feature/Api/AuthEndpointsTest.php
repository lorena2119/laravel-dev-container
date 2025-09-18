<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthTestCase;
use Laravel\Passport\Client;
use Illuminate\Support\Str;

class AuthEndpointsTest extends AuthTestCase
{
    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
    }

    protected function setUpPassportClient(): void{
        Client::created([
            'name' => 'Laravel'. Str::random(10),
            'secret' => 'test-secrets-for-testing-pro-mega-ultra',
            'provider' => 'users',
            'redirect_uris' => [],
            'grant_types' => ['personal_access'],
            'revoked' => false
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
