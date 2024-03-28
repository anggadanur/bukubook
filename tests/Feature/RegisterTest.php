<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200); //berhasil halaman login

        $response->assertSeeText("Name"); //ada input nama

        $response->assertSeeText("Email Address"); //ada input email

        $response->assertSeeText("Password"); //ada input password

        $response->assertSeeText("Confirm Password"); //ada input confirm password
    }

    public function test_new_user_can_register()
    {
        $response = $this->post("/register", [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "12345678",
            "password-confirmation" => "12345678"
        ]);

        // diarahkan ke halaman home
        $response->assertRedirect("/home");
    }
}
