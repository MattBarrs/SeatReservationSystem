<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Institution;
use App\Models\User_Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function show()
    {
        $userId = Auth::id();
        $user_booking = User_Booking::
                where('user_id',$userId)
                ->orderby('created_at','desc')
                ->first();

        $upcoming_bookings = User_Booking::
                join('bookings','bookings.id','=','user_Bookings.id')
                ->where('user_id',$userId)
                ->where('bookings.start_date','>=',Carbon::today())
                ->take(5)
                ->get();

        if($user_booking != "")
        {
            $bookingID = $user_booking->id;
            $booking = Bookings::where('id', $bookingID)->first();
        }
        else
        {
            $booking = "";
            $upcoming_bookings = "";
        }
        $institutes_all = Institution::select('institution_name')->orderBy('institution_name','ASC')->get();

        return view('dashboard', ['booking' => $booking, 'institutes'=>$institutes_all, 'upcoming_bookings'=>$upcoming_bookings]);
    }
    public function sandbox(){
        return view('sandbox');
    }

}
