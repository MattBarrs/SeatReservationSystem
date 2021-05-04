<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class redirectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/dashboard')
            ->assertRedirect('/login');

        $response = $this->get('/dashboard')
            ->assertRedirect('/login');

        $response = $this->get('/institution')
            ->assertRedirect('/login');

        $response = $this->get('/institution/create')
            ->assertRedirect('/login');

        $response = $this->get('/bookings')
            ->assertRedirect('/login');

        $response = $this->get('/bookings/create')
            ->assertRedirect('/login');

        $response = $this->get('/bookings/create/rooms')
            ->assertRedirect('/login');

        $response = $this->get('/rooms/edit')
            ->assertRedirect('/login');

        $response = $this->get('/rooms/editseats')
            ->assertRedirect('/login');

        $response = $this->get('/rooms/selectEdit')
            ->assertRedirect('/login');

        $response = $this->get('/trackAndTrace')
            ->assertRedirect('/login');
    }
}
