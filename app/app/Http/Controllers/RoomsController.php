<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
class RoomsController extends Controller
{
    public function index()
    {
        $room = Rooms::latest()->get();
        return view
        ('rooms.index',
            [
                'rooms' => $room,
                'open_time' => request('open_time'),
                'close_time' => request('close_time'),
                'bookingCode' => request('bookingCode'),
                'referenceLength' => request('referenceLength'),
            ],
        );
    }

    public function show($id)
    {
        $room = Rooms::findOrFail($id);
        return view('rooms.show',['Room' => $room]);
    }

    public function  create(){
        return view('rooms.create');
    }

    public function store(){
        $room = new Rooms();

        $room->room_name = request('roomName');
        $room->open_time = request('open_time');
        $room->close_time = request('close_time');
        $room->booking_code = "ABC";
        //        $room->booking_code = request('booking_code');
        $room->reference_length = 10.0;
        $room->floor_plan = "s";
//        request(file('floor_plan'));


        $room->save();

        return redirect('/')->with('mssg','Room Created Successfully');

    }

    public function destroy($id){
        $room = Rooms::findOrFail($id);
        $room->delete();

        return redirect(route('rooms.index'));
    }
}
