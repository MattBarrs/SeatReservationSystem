<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Institution;
use App\Models\User_Booking;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;


#controller for the main page - known as  dashboard
class DashboardController extends Controller
{

    public function show()
    {
        #get user ID
        $userId = Auth::id();

        #find their latest booking
        $user_booking = User_Booking::
                where('user_id',$userId)
                ->orderby('created_at','desc')
                ->first();

        #find up to 5 bookings after current day
        $upcoming_bookings = User_Booking::
                join('bookings','bookings.id','=','user_Bookings.id')
                ->where('user_id',$userId)
                ->where('bookings.start_date','>=',Carbon::today())
                ->take(5)
                ->get();

        #if the user has a booking get the 1st
        if($user_booking != "")
        {
            $bookingID = $user_booking->id;
            $booking = Bookings::where('id', $bookingID)->first();
        }
        #if user has no bookings
        else
        {
            $booking = "";
            $upcoming_bookings = "";
        }

        #return list of available institutions
        $institutes_all = Institution::select('institution_name')->orderBy('institution_name','ASC')->get();

        return view('dashboard', ['booking' => $booking, 'institutes'=>$institutes_all, 'upcoming_bookings'=>$upcoming_bookings]);
    }

}
