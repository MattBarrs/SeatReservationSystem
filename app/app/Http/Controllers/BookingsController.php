<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\Bookings;
use App\Models\User_Booking;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\s;


class BookingsController extends Controller
{
    public function index()
    {
        $booking = Bookings::join('Rooms','Bookings.room_name','Rooms.room_name')
            ->select('Bookings.seat_name','Bookings.start_date','Bookings.start_time','Bookings.end_time','Bookings.id','Rooms.room_name')
            ->get();
        return view
        ('bookings.index',
            [
                'bookings' => $booking,
                'name' => request('name'),
                'seat' => request(' seat'),
                'duration' => request('duration'),
                'seat_details' => request('seat_details'),
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
            $seats = Workstation::
                where('room_name',$room)
                ->where('institution_name',$institution)
                ->select('Workstations.seat_name')
                ->get();
            return view('bookings.create', ['seats'=>$seats]);
        }
    }

    public function store(Request $request){

        $institution = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');

        $selected_room = Rooms::where('institution_name',$institution)->where('room_name',$room)->get();

        $roomOpen = $selected_room[0]->open_time;
        $roomClose = $selected_room[0]->close_time;
        $openTimeMessage = \Carbon\Carbon::createFromFormat('H:i:s',$roomOpen)->format('h:i A');
        $closeTimeMessage = \Carbon\Carbon::createFromFormat('H:i:s',$roomClose)->format('h:i A');

        $rules = [
            'seat' => 'required',
            'start_date' => 'required|after_or_equal:yesterday',
            'start_time' => "required|after_or_equal:$roomOpen",
            'end_time' => "required|after_or_equal:start_time|before_or_equal:$roomClose",
        ];


        $customMessages = [
            'start_date.after_or_equal' => "Invalid date selected. Date must be today or in the future ",
            'end_time.after_or_equal' => "Start time must be before end time.",
            'end_time.before_or_equal' => "This facility closes at $closeTimeMessage.",
            'start_time.after_or_equal' => "This facility opens at $openTimeMessage.",

        ];

        $this->validate($request,$rules,$customMessages);

        $booking = new Bookings();
        $booking->room_name = $room;
        $booking->institution_name = $institution;
        $booking->seat_name = request('seat');
        $booking->start_date = request('start_date');
        $booking->start_time = request('start_time');
        $booking->end_time = request('end_time');

        $booking->save();

        $user_booking = new User_Booking();

        $bookingID= Bookings::latest('created_at')->first()->id;
        $userId = Auth::id();
        $user_booking->id = $bookingID;
        $user_booking->user_id = $userId;

        $user_booking->save();

        return redirect('/dashboard')->with('mssg',"Booking Successful");

    }

    public function selectRoom(Request $request)
    {
        $value   = request("submit");

        $institution = $request->session()->get('institution_name');
        $room = Rooms::where('institution_name',$institution)->get();

        if($value != null)
        {
            $request->session()->put('selected_room', $value);

            $selected_room = Rooms::where('institution_name',$institution)->where('room_name',$value)->first();

            $roomOpen = $selected_room->open_time;
            $roomClose = $selected_room->close_time;

            $request->session()->put('open_time',$roomOpen);
            $request->session()->put('close_time',$roomClose);

            return redirect('/bookings/create');
        }
        elseif($room == "[]")
        {
            return view('bookings.selectRoom');

        }
        else
        {
            return view('bookings.selectRoom', ['rooms' => $room]);
        }
    }


    public function destroy($id){
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        $user_booking = User_Booking::findOrFail($id);
        $user_booking->delete();

        return redirect('/dashboard')->with('mssg','Booking Deleted Successfully');
    }


}
