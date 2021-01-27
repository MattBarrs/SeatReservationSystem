<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
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

    public function  selectInstitution(){
        return view('bookings.institution');
    }

    public function  create(Request $request){
        $institution = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');
        if($institution == null)
        {
            return redirect('/institution');
        }
        elseif($room == null) {
            return redirect('/bookings/create/rooms');
        }
        else
        {
            return view('bookings.create');
        }
    }

    public function store(Request $request){
        $booking = new Bookings();

        $institue = $request->session()->get('institution_name');


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

        //$booking->roomId = request('roomcode');
        $booking->roomId = 1;
        $booking->institution_name = $institue;
        $booking->seatID = request('seat');
        $booking->start_date = request('start_date');
        $booking->start_time = request('start_time');
        $booking->end_time = request('end_time');
        $booking->extra_requirements = request('extra_requirements');

        $booking->save();

        return redirect('/dashboard')->with('mssg','Booking Created Successfully');

    }

    public function selectRoom(Request $request)
    {
        $value   = request("submit");
        $institution = $request->session()->get('institution_name');
        $room = Rooms::where('institution_name',$institution)->get();

        if($value != null)
        {
            $request->session()->put('selected_room', $value);
            return redirect('/bookings/create');
        }
        return view
        ('bookings.selectRoom',
            [
                'rooms' => $room,
                'open_time' => request('open_time'),
                'close_time' => request('close_time'),
                'bookingCode' => request('bookingCode'),
                'institution_name' => request('institution_name'),
                'referenceLength' => request('referenceLength'),
            ],
        );
    }


    public function destroy($id){
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        return redirect(route('bookings.index'));
    }


}
