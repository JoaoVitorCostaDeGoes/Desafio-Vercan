<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        //$response->assertStatus(200); descoberto erro de retorno esperado, devido redirecionamento do laravel UI para login quando acesso as rotas nao fosse autenticado!
        $response->assertRedirect();
    }
}
