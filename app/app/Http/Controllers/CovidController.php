<?php

namespace App\Http\Controllers;
use App\Models\Rooms;
use App\Models\Bookings;
use App\Models\Institution;

use App\Models\User;
use App\Models\User_Booking;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CovidController extends Controller
{
    public function trackAndTrace(Request $request)
    {
        $sessionId = Auth::id(); #gets user ID from session
        $institutes_all = Institution::select('institution_name')->orderBy('institution_name','ASC')->get();
        $rooms_all = Rooms::select('room_name')->orderBy('room_name','ASC')->get();

        #Joins user bookings and bookings tables,
        #finds where the bookings belong to user
        #Returns the relevant details to be displayed
        $booking = Bookings::
        join('Rooms','Bookings.room_name','Rooms.room_name')
            ->join('User_Bookings','Bookings.id','User_Bookings.id')
            ->where('User_Bookings.user_id',$sessionId)
            ->select('Bookings.seat_name','Bookings.start_date','Bookings.start_time','Bookings.end_time','Bookings.id','Rooms.room_name')
            ->get();
        return view('covid.trackAndTrace' , ['institutes'=>$institutes_all, 'rooms'=>$rooms_all]);
//        return view('dashboard', ['booking' => $booking, 'institutes'=>$institutes_all, 'upcoming_bookings'=>$upcoming_bookings]);

    }

    public function returnContacts(Request $request){
//        error_log("Starting");


        $stringData = strval($request['data']);

        $data = json_decode($stringData,true);
        $room = $data['room'];
        $institute = $data['institute'];

        $time_HH = $data['time']['HH'];
        $time_mm = $data['time']['mm'];
        $time =  $time_HH.":". $time_mm . ":00";

        $date = $data['date'];
        $date = date('Y-m-d', strtotime($date));

        $bookings = Bookings::
            join('Rooms','Bookings.room_name','=','Rooms.room_name')
            ->join('User_Bookings','Bookings.id','=','User_Bookings.id')
            ->where('Bookings.room_name','=',$room)
            ->where('Bookings.institution_name','=',$institute)
            ->where('Bookings.start_time','=',$time)
            ->where('Bookings.start_date','=',$date)
            ->select('User_Bookings.user_id')
            ->get();

        $userIDs = array();
        foreach ($bookings as $booking){
            if( ! (in_array($booking->user_id, $userIDs)) ) {
                $int = $booking->user_id ;
                array_push($userIDs, strval($int) );

            }
        }

        $userEmails = array();
        foreach($userIDs as $id){
            $userEmail = User::where('id',$id)->select('email')->first();
            array_push($userEmails, strval($userEmail) );

        }

        return response()->json([$userEmails]);

    }


}
