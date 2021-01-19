<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookings;

class BookingsController extends Controller
{
    public function index()
    {
        $booking = Bookings::latest()->get();
        return view
        ('bookings.index',
            [
                'bookings' => $booking,
                'name' => request('name'),
                'seat' => request(' seat'),
                'duration' => request('duration'),
                'extra_requirements' => request('extra_requirements'),
            ],
        );
    }

    public function show($id)
    {
        $booking = Bookings::findOrFail($id);
        return view('bookings.show',['Booking' => $booking]);
    }

    public function  create(){
        return view('bookings.create');
    }

    public function store(Request $request){
        $booking = new Bookings();

        $rules = [
            'roomCode' => 'required',
            'seat' => 'required',
            'start_date' => 'required|after:yesterday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ];

        $customMessages = [
            'start_date.after' => "Invalid date selected. Date must be today or in the future ",
            'end_time.after' => "'Start Time' must be before 'End Time'."

        ];

        $this->validate($request,$rules,$customMessages);
//        $booking->roomId = request('roomcode');
        $booking->roomId = 1;
        $booking->seatID = request('seat');
        $booking->start_date = request('start_date');
        $booking->start_time = request('start_time');
        $booking->end_time = request('end_time');
        $booking->extra_requirements = request('extra_requirements');

        $booking->save();

        return redirect('/dashboard')->with('mssg','Booking Created Successfully');

    }

    public function destroy($id){
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        return redirect(route('bookings.index'));
    }


}
