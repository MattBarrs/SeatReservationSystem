<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Institution;
use App\Models\User_Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {
        $userId = Auth::id();
        $user_booking = User_Booking::where('user_id',$userId)->orderby('created_at','desc')->first();
        if($user_booking != "")
        {
            $bookingID = $user_booking->id;
            $booking = Bookings::where('id', $bookingID)->first();
        }
        else
        {
            $booking = "";
        }
        $institutes_all = Institution::select('institution_name')->get();

        return view('dashboard', ['booking' => $booking, 'institutes'=>$institutes_all]);
    }


}
