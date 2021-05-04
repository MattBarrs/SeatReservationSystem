<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class postErrorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->post('/institution');
        $response->assertStatus(500);


        $response = $this->actingAs($user)->post('/bookings/getAvailable');
        $response->assertStatus(500);

        $response = $this->actingAs($user)->post('/bookings/createBooking');
        $response->assertStatus(500);

        $response = $this->actingAs($user)->post('/trackAndTrace');
        $response->assertStatus(500);

        $response = $this->actingAs($user)->post('/rooms/editseats');
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post('/institution/create');
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post('rooms/edit');
        $response->assertStatus(302);
    }
}
