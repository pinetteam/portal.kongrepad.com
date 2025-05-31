<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * Test ana sayfa çalışıyor mu
     */
    public function test_homepage_returns_200(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test API rotaları
     */
    public function test_api_routes_work(): void
    {
        // API ana endpoint
        $response = $this->get('/api');
        $response->assertStatus(200);
    }

    /**
     * Test olmayan rota 404 döndürüyor mu
     */
    public function test_nonexistent_route_returns_404(): void
    {
        $response = $this->get('/bu-sayfa-yok');
        $response->assertStatus(404);
    }

    /**
     * Test login sayfası
     */
    public function test_login_page_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Test dashboard (auth gerekli)
     */
    public function test_dashboard_redirects_without_auth(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302); // redirect to login
    }
}