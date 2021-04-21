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
    }

    public function returnContacts(Request $request){


        $stringData = strval($request['data']);

        $data = json_decode($stringData,true);
        $room = $data['room'];
        $institute = $data['institute'];

        $start_time_HH = $data['time']['HH'];
        $start_time_mm = $data['time']['mm'];
        $start_time =  $start_time_HH.":". $start_time_mm . ":00";


        $end_time_HH = $start_time_HH ;
        $end_time_mm = $start_time_mm + 59;
        if($end_time_mm>60){
            $end_time_mm = $end_time_mm % 60;
            $end_time_HH = $end_time_HH + 1;
        }
        if($end_time_HH>24){
            $end_time_HH = $end_time_HH % 24;
        }
        $end_time =  $end_time_HH.":". $end_time_mm . ":00";
        error_log(print_r($end_time, TRUE) );
        $date = $data['date'];
        $date = date('Y-m-d', strtotime($date));

        $userIDs = Bookings::
            join('Rooms','Bookings.room_name','=','Rooms.room_name')
            ->join('User_Bookings','Bookings.id','=','User_Bookings.id')
            ->where('Bookings.room_name','=',$room)
            ->where('Bookings.institution_name','=',$institute)
            ->where(function($query) use ($end_time, $start_time)
            {
                $query->where(function($query) use ($start_time){
                    $query->where('Bookings.start_time', '<=', $start_time)
                        ->where('Bookings.end_time', '>=',  $start_time);
                })
                    ->orWhere(function($query) use ($end_time) {
                        $query->where('Bookings.start_time', '<=', $end_time)
                            ->where('Bookings.end_time', '>=', $end_time);
                    });
            })
            ->where('Bookings.start_date','=',$date)
            ->select('User_Bookings.user_id')
            ->get();


        $userIDs_array = array();
        foreach ($userIDs as $uID){
//            error_log($uID->user_id);

            if( ! (in_array($uID->user_id, $userIDs_array)) ) {
                error_log("adding");
                $int = $uID->user_id ;
                array_push($userIDs_array, strval($int) );

            }
        }

        $userEmails = array();
        foreach($userIDs_array as $id){
            $userEmail = User::where('id',$id)->select('email')->first();
            array_push($userEmails, strval($userEmail->email) );

        }
//        error_log( print_r ($userEmails, TRUE));
        return response()->json([$userEmails]);

    }


}
