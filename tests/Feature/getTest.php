<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(302);

        $response = $this->get('/dashboard');
        $response->assertStatus(302);

        $response = $this->get('/institution');
        $response->assertStatus(302);

        $response = $this->get('/institution/create');
        $response->assertStatus(302);

        $response = $this->get('/bookings');
        $response->assertStatus(302);

        $response = $this->get('/bookings/create');
        $response->assertStatus(302);

        $response = $this->get('/bookings/create/rooms');
        $response->assertStatus(302);

        $response = $this->get('/rooms/edit');
        $response->assertStatus(302);

        $response = $this->get('/rooms/editseats');
        $response->assertStatus(302);

        $response = $this->get('/rooms/selectEdit');
        $response->assertStatus(302);

        $response = $this->get('/trackAndTrace');
        $response->assertStatus(302);

        $response = $this->get('/trackThenTrace');
        $response->assertStatus(404);

        $response = $this->get('/editRoom');
        $response->assertStatus(404);

        $response = $this->get('/booking');
        $response->assertStatus(404);

        $response = $this->get('/showbooking');
        $response->assertStatus(404);

        $this->assertTrue(true);

    }
}
