<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\Bookings;
use App\Models\User_Booking;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use function Symfony\Component\String\s;


class BookingsController extends Controller
{
    #Shows the user all of their bookings
    public function index(Request $request)
    {
        $sessionId = Auth::id(); #gets user ID from session

        #Joins user bookings and bookings tables,
        #finds where the bookings belong to user
        #Returns the relevant details to be displayed
        $booking = Bookings::
            join('Rooms','Bookings.room_name','Rooms.room_name')
            ->join('User_Bookings','Bookings.id','User_Bookings.id')
            ->where('User_Bookings.user_id',$sessionId)
            ->select('Bookings.seat_name','Bookings.start_date','Bookings.start_time','Bookings.end_time','Bookings.id','Rooms.room_name')
            ->get();
        return view('bookings.index',['bookings' => $booking]);
    }

    #Show individual booking
    #Takes the booking ID as input
    public function show(Request $request,$id)
    {
        $user_bookings = User_Booking::find($id);
        $sessionId = Auth::id();

        #finds the user booking that the user requested
        #will only show to the user if the userID
        if( $user_bookings->user_id == $sessionId)
        {
            $booking = Bookings::findOrFail($id);
            return view('bookings.show',['Booking' => $booking]);
        }
        else{
            #if booking not found or not their booking.
            return redirect('/dashboard')->withErrors('You are not authorised to view this booking');
        }

    }

    #Page used to select the institutions
    public function  selectInstitution(){
        return view('bookings.institution');
    }

    #Creating a new booking
    public function  create(Request $request){
        #get the room name and the institution name
        $institution = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');

        #ensures they have an institution selected
        if($institution == null)
        {
            return redirect('/institution');
        }
        #ensures that they have a room selected
        elseif($room == null) {
            return redirect('/bookings/create/rooms');
        }
        else
        {
            #returns a list of all of the seats for the room&institute pair
            $seats = Workstation::
                where('room_name',$room)
                ->where('institution_name',$institution)
                ->select('Workstations.seat_name')
                ->get();
            $rooms  = Rooms::
                where('institution_name',$institution)
                ->where('room_name',$room)
                ->first();
//            return view('sandbox')
//                ->with('rooms',$rooms);

            return view('bookings.create')
                    ->with('rooms',$rooms)
                    ->with('seats',$seats);
        }
//  return view('sandbox')
//            ->with('rooms',$rooms);
    }








    #storing the data for the new booking
    public function store(Request $request){
        #get the room name and the institution name
        $institution = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');
        #gets details about room
        $selected_room = Rooms::where('institution_name',$institution)->where('room_name',$room)->get();

        #used to ensure the times are correct
        $roomOpen = $selected_room[0]->open_time;
        $roomClose = $selected_room[0]->close_time;
        $openTimeMessage = Carbon::createFromFormat('H:i:s',$roomOpen)->format('h:i A');
        $closeTimeMessage = Carbon::createFromFormat('H:i:s',$roomClose)->format('h:i A');

        #validation rules
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

        #createe new instance of bookings, assign the data from the user and then save to table.
        $booking = new Bookings();
        $booking->room_name = $room;
        $booking->institution_name = $institution;
        $booking->seat_name = request('seat');
        $booking->start_date = request('start_date');
        $booking->start_time = request('start_time');
        $booking->end_time = request('end_time');

        $booking->save();

        #create new instance of User_bookings, assign the data from the user and then save to table.
        $user_booking = new User_Booking();

        $bookingID= Bookings::latest('created_at')->first()->id;
        $userId = Auth::id();
        $user_booking->id = $bookingID;
        $user_booking->user_id = $userId;

        $user_booking->save();

        return redirect('/dashboard')->with('mssg',"Booking Successful");

    }

    #user selects which room they want to book into
    public function selectRoom(Request $request)
    {
        #get value from the select Room page
        $value   = request("submit");

        $institution = $request->session()->get('institution_name');
        #get rooms associated with the institution
        $room = Rooms::where('institution_name',$institution)->get();

        #if the user has submitted which room they would like to book
        if($value != null)
        {
            #store the room in the session variables
            $request->session()->put('selected_room', $value);

            #find relevant room details and save to session variables
            $selected_room = Rooms::where('institution_name',$institution)->where('room_name',$value)->first();

            $roomOpen = $selected_room->open_time;
            $roomClose = $selected_room->close_time;

            $request->session()->put('open_time',$roomOpen);
            $request->session()->put('close_time',$roomClose);

            return redirect('/bookings/create');
        }
        #if their institute has no rooms
        elseif($room == "[]")
        {
            return view('bookings.selectRoom');

        }
        #if the user has not submitted which room they want and their institute has rooms associated with it
        else
        {
            return view('bookings.selectRoom', ['rooms' => $room]);
        }
    }

    public function filterRooms(Request $request)
    {
        #used to filter out rooms which do/don't meet certain crieria
        $value   = request("room_details");
        $asJSON = json_encode($value);

        $institution = $request->session()->get('institution_name');

        #find correct rooms
        $filteredRooms = Rooms::
            where('institution_name',$institution)
            ->where('room_details','like',$asJSON)
            ->get();


        if($value != null)
        {
            return view('bookings.selectRoom', ['rooms' => $filteredRooms]);
        }
        else
        {
            return redirect('bookings/create/rooms')->withErrors('No criteria selected for filter.');;
        }
    }

    public function destroy($id){
        #delete booking from the bookings table
        #as well as the user_bookings table as they're linked
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        $user_booking = User_Booking::findOrFail($id);
        $user_booking->delete();

        return redirect('/dashboard')->with('mssg','Booking Deleted Successfully');
    }


}
