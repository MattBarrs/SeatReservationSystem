<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\Bookings;
use App\Models\UserBooking;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use function Symfony\Component\String\s;

/**
 * Class BookingsController
 * @package App\Http\Controllers
 */
class BookingsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    #Shows the user all of their bookings
    public function index(Request $request)
    {
        $sessionId = Auth::id(); #gets user ID from session

        #Joins user bookings and bookings tables, finds where the bookings belong to user
        #Returns the relevant details to be displayed
        $pastBookings = Bookings::
        join('Rooms','Bookings.room_name','Rooms.room_name')
            ->join('User_Bookings','Bookings.id','User_Bookings.id')

            ->where('User_Bookings.user_id',$sessionId)
            ->where('Bookings.start_date','<',Carbon::today())

            ->select('Bookings.seat_name','Bookings.start_date','Bookings.start_time','Bookings.end_time','Bookings.id','Rooms.room_name', 'Bookings.institution_name')
            ->orderBy('Bookings.start_date','desc')
            ->orderBy('Bookings.institution_name','desc')
            ->get();

        $futureBookings = Bookings::
        join('Rooms','Bookings.room_name','Rooms.room_name')
            ->join('User_Bookings','Bookings.id','User_Bookings.id')

            ->where('User_Bookings.user_id',$sessionId)
            ->where('bookings.start_date','>=',Carbon::today())

            ->select('Bookings.seat_name','Bookings.start_date','Bookings.start_time','Bookings.end_time','Bookings.id','Rooms.room_name', 'Bookings.institution_name' )
            ->orderBy('bookings.start_date','asc')
            ->orderBy('Bookings.institution_name','desc')

            ->get();

        return view('bookings.index')
            ->with(['futureBookings'=>$futureBookings])
            ->with(['pastBookings'=>$pastBookings]);

    }

    #

    /**
     * Show individual booking, takes the booking ID as input
     *
     * @param Request $request :: data from the request/ user
     * @param $id :: booking they want to see
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(Request $request,$id)
    {
        $User_Bookings = UserBooking::find($id);
        $sessionId = Auth::id();

        #finds the user booking that the user requested
        #will only show to the user if the userID
        if( $User_Bookings->user_id == $sessionId)
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

    /**
     * saves the booking the user creates
     * @param Request $request :: data from the request/ user
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveBooking(Request $request){

        #retrive data from the axios post and convert to string then assign to variables

        $stringData = strval($request['data'] );
        $request['data'] = json_decode($stringData,true);
        $data = json_decode($stringData,true);



        $startHour = $data['start_hour'];
        $startMinute = $data['start_minute'];
        $startTime = $startHour.":".$startMinute.":00";
        $startTime  = strval($startTime);

        $endHour = $data['end_hour'];
        $endMinute = $data['end_minute'];
        $endTime = $endHour.":".$endMinute.":00";
        $endTime = strval($endTime);

        $date= $data['date'];
        $date = date('Y-m-d', strtotime($date));

        $seat = $data['seat'];

        #get the room name and the institution name
        $institution = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');

        #gets user ID from session
        $sessionId = Auth::id();

        $findBookings = Bookings::
            join('User_Bookings','Bookings.id','User_Bookings.id')

            ->where('User_Bookings.user_id',$sessionId)
            ->where('Bookings.start_date', '=',$date)

            ->where(function($query) use ($endTime, $startTime)
            {
                $query->where(function($query) use ($endTime, $startTime){
                    $query->where('Bookings.start_time', '<=', $startTime)
                        ->where('Bookings.end_time', '>=',  $startTime);
                })
                    ->orWhere(function($query) use ($endTime, $startTime) {
                        $query->where('Bookings.start_time', '<=', $endTime)
                            ->where('Bookings.end_time', '>=', $endTime);
                    });
            })

            ->orderBy('Bookings.institution_name','desc')
            ->get();

        #if the user do not have a booking at that time
        if( $findBookings == "[]"){

            $booking = new Bookings();
            $booking->room_name = $room;
            $booking->institution_name = $institution;
            $booking->seat_name = $seat;
            $booking->start_date = $date;
            $booking->start_time = $startTime;
            $booking->end_time = $endTime;

            $booking->save();

            $UserBooking = new UserBooking();

            $bookingID= Bookings::latest('created_at')->first()->id;
            $userId = Auth::id();
            $UserBooking->id = $bookingID;
            $UserBooking->user_id = $userId;

            $UserBooking->save();
        }
        else{

            $roomName = $findBookings->first()->room_name;
            $errorMessage  = "You already have a booking at this time in the '". $roomName. "' room. ";

            return response()->json([
                'status' => 'error',
                'messages' => 'Error',
                'errors' => strval($errorMessage),
            ], 400);
        }



    }

    /** Creating a new booking page
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

            return view('bookings.create')
                    ->with('rooms',$rooms)
                    ->with('seats',$seats);
        }
    }

    /**
     * storing the data for the new booking
     *
     * @param Request $request :: data from the request/ user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
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

        #create new instance of User_Bookings, assign the data from the user and then save to table.
        $UserBooking = new UserBooking();

        $bookingID= Bookings::latest('created_at')->first()->id;
        $userId = Auth::id();
        $UserBooking->id = $bookingID;
        $UserBooking->user_id = $userId;

        $UserBooking->save();

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



    public function destroy($id){
        #delete booking from the bookings table
        #as well as the User_Bookings table as they're linked
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        $UserBooking = UserBooking::findOrFail($id);
        $UserBooking->delete();

        return redirect('/dashboard')->with('mssg','Booking Deleted Successfully');
    }

    public function getAvailable(Request $request){

        $institute = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');

        #retrieve data, decode and assign to variables
        $data = json_decode($request['data'],true);
        $startTime = $data['start_hour'] . ":" . $data['start_minute'].":00";

        $date = $data['date'];
        $date = date('Y-m-d', strtotime($date));

        $endTime = $data['end_hour'] . ":" . $data['end_minute'].":00";

        #checks to see if any bookings overlap with the date/time/room given
        $booking = Bookings::where('room_name',$room)
                ->where('institution_name',$institute)
                ->where('start_date',$date)
                ->where(function($query) use ($endTime, $startTime)
                {
                    $query->where(function($query) use ($endTime, $startTime){
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=',  $startTime);
                    })
                        ->orWhere(function($query) use ($endTime, $startTime) {
                            $query->where('start_time', '<=', $endTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->get();
        return response()->json([$booking]);
    }
}
