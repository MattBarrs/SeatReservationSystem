<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Institution;
use App\Models\UserBooking;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;




/**
 * controller for the main page - known as  dashboard
 *
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        #get user ID
        $userId = Auth::id();

        #find their latest booking
        $UserBooking = UserBooking::
                where('user_id',$userId)
                ->orderby('created_at','desc')
                ->first();

        #find up to 5 bookings after current day
        $upcoming_bookings = UserBooking::
                join('bookings','bookings.id','=','User_Bookings.id')
                ->where('user_id',$userId)
                ->where('bookings.start_date','>=',Carbon::today())
                ->take(5)
                ->get();

        #if the user has a booking get the 1st
        if($UserBooking != "")
        {
            $bookingID = $UserBooking->id;
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
