<?php

namespace Tests\Feature;

use App\Models\Bookings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class showRoomsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {


        $user = User::find(1);

        $booking = new Bookings();
        $booking->id = 1;
        $booking->room_name = "Example room";
        $booking->institution_name = "Example institution";
        $booking->seat_name = 12;
        $booking->start_date = "2050-02-01";
        $booking->start_time = "07:00:00";
        $booking->end_time = "07:59:00";
//        $response = $this->get('/');
        $view = $this->actingAs($user)->view('bookings.show', ['Booking' => $booking]);

        $view->assertSee('Example room');

    }
}
