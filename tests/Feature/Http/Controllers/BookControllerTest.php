<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    public function testAccessProtectedRouterWithoutAuthShouldBeBlocked()
    {
        $response = $this->get('/api/books');

        $response->assertStatus(401);
    }

    public function testAccessProtectedRouterWithAuthShouldBeOk()
    {
        $response = $this->get('/api/books', [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(200);
    }

    public function testCreateBookWithInvalidFieldsShouldReturnError()
    {

        $response = $this->post('/api/books', [], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(422);
    }

    public function testCreateBookWithValidFieldsShouldReturnOk()
    {
        $response = $this->post('/api/books', [
            'name' => fake()->name(),
            'isbn' => fake()->isbn13(),
            'value' => 10.20
        ], [
            'Authorization' => 'Bearer ' . $this->getToken()
        ]);

        $response->assertStatus(201);
    }

    public function testCanSeeBookByIdShouldBeOk()
    {
        $token = $this->getToken();
        $response = $this->post('/api/books', [
            'name' => fake()->name(),
            'isbn' => fake()->isbn13(),
            'value' => 10.20
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);

        $book = $response->json();

        $response = $this->get('/api/books/' . $book['data']['id'], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }


    public function testDeleteBookShouldSeeNotFound()
    {
        $token = $this->getToken();
        $response = $this->post('/api/books', [
            'name' => fake()->name(),
            'isbn' => fake()->isbn13(),
            'value' => 10.20
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);

        $book = $response->json();

        $response = $this->get('/api/books/' . $book['data']['id'], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);


        $response = $this->delete('/api/books/' . $book['data']['id'], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(202);


        $response = $this->get('/api/books/' . $book['data']['id'], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(404);
    }

    private function getToken()
    {

        $user = $this->get('/api/generate-user')->json();

        $login = $this->post('api/auth', ['email' => $user['user'], 'password' => $user['password']])->json();

        return $login['data']['token'];
    }
}
