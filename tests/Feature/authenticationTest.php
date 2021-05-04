<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class authenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // find specific user
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);


        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/institution');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/institution/create');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/bookings');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/bookings/create/rooms');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/trackAndTrace');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/trackThenTrace');
        $response->assertStatus(404);

        $response = $this->actingAs($user)->get('/editRoom');
        $response->assertStatus(404);

        $response = $this->actingAs($user)->get('/booking');
        $response->assertStatus(404);

        $response = $this->actingAs($user)->get('/showbooking');
        $response->assertStatus(404);

        $this->assertTrue(true);

    }
}
