<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $resp = $this->postJson('/api/register', [
            'name'=>'Test User',
            'email'=>'test@example.com',
            'password'=>'password',
            'password_confirmation'=>'password'
        ]);

        $resp->assertStatus(201)->assertJsonStructure(['user','token']);

        $login = $this->postJson('/api/login', [
            'email'=>'test@example.com',
            'password'=>'password'
        ]);

        $login->assertStatus(200)->assertJsonStructure(['user','token']);
    }
}
