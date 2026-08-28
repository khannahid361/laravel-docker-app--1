<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthRateLimitingTest extends TestCase
{
    public function test_login_route_rate_limiting()
    {
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/login', [
                'email' => 'test@example.com',
                'password' => 'password',
            ]);
            
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(429);
    }
}
