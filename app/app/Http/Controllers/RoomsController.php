<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
class RoomsController extends Controller
{
    public function index(Request $request)
    {
        $institution = $request->session()->get('institution_name');
        $room = Rooms::latest()->get();
        return view
        ('rooms.index',
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

    public function show($id)
    {
        $room = Rooms::findOrFail($id);
        return view('rooms.show',['Room' => $room]);
    }

    public function  create(Request $request){
            $institution = $request->session()->get('institution_name');

            if( $institution == null)
            {
                return redirect('/institution');
            }
            else{
                return view('rooms.create');
        }
    }

    public function store(Request $request){
        $room = new Rooms();
        $institue = $request->session()->get('institution_name');

        $rules = [
            'room_name' => 'required',
            'open_time' => 'required',
            'close_time' => 'required|after:open_time',
//            'reference_length' => 'required',
            'numOfSeats' => 'required'
        ];

        $customMessages = [
            'close_time.after' => "Closing time must be after Opening time."
        ];

        $this->validate($request,$rules,$customMessages);

        $room->institution_name = $institue;
        $room->booking_code = "ABC";
        $room->room_name = request('room_name');
        $room->open_time = request('open_time');
        $room->close_time = request('close_time');
        $room->floor_plan = "s"; //For java interactive section
        $room->reference_length = 10.0; //Reference length to allow distance guaging
        //$room->booking_code = request('booking_code');
        //request(file('floor_plan'));


        $room->save();

        return redirect('/')->with('mssg','Room Created Successfully');

    }

    public function destroy($id){
        $room = Rooms::findOrFail($id);
        $room->delete();

        return redirect(route('rooms.index'));
    }
}
