<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200); //berhasil halaman login

        $response->assertSeeText("Email Address"); //ada input email address

        $response->assertSeeText("Password"); //ada input password
    }

    public function test_admin_can_login_to_app()
    {
        $response = $this->post("/login", [
            "email" => "admin@bukubook.com",
            "password" => "4dm1n"
        ]);

        // berhasil dapat session
        $this->assertAuthenticated();

        // diarahkan ke halaman home
        $response->assertRedirect("/home");

        // di halaman home ada welcome admin
        $responseHome = $this->get("/home");
        $responseHome->assertSeeText("ADMIN BUKUBOOK (ADMIN)");
    }

    public function test_logged_in_user_can_logout()
    {
        // login admin
        $response = $this->post("/login", [
            "email" => "admin@bukubook.com",
            "password" => "4dm1n"
        ]);

        // assert authenticated
        $this->assertAuthenticated();

        // request get ke /home
        $this->get("/home");

        // buat request method POST ke /logout
        $this->post("/logout");

        // request get ke /home
        $responseHome = $this->get("/home");

        // assert redirect ke halaman login
        $responseHome->assertRedirect("/login");
    }
}
