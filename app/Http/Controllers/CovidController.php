<?php

namespace App\Http\Controllers;
use App\Models\Rooms;
use App\Models\Bookings;
use App\Models\Institution;

use App\Models\User;
use App\Models\UserBooking;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CovidController
 * @package App\Http\Controllers
 */
class CovidController extends Controller
{
    /**
     * Used to ensure the user has the correct permissions
     * @param $request :: data from the request/ user
     * @return bool :: do they have permission True or False
     */
    private function checkPermission($request)
    {
        $user = $request->user();
        if($user->id === 1){
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * if they have permission get all the institues and rooms in the db  for the drop downs
     * @param Request $request :: data from the request/ user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function trackAndTrace(Request $request)
    {
        if($this->checkPermission($request) == true) {
            $institutes_all = Institution::select('institution_name')->orderBy('institution_name', 'ASC')->get();
            $rooms_all = Rooms::select('room_name')->orderBy('room_name', 'ASC')->get();

            return view('covid.trackAndTrace', ['institutes' => $institutes_all, 'rooms' => $rooms_all]);
        }
        else{
            return redirect('/')->with('mssg','You do not have permission to view this.');

        }
    }

    /**
     *      retrieve the emails of everyone who was in the room at the date/time given
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function returnContacts(Request $request){
        if($this->checkPermission($request) == true) {

            $stringData = strval($request['data']);

            $data = json_decode($stringData, true);
            $room = $data['room'];
            $institute = $data['institute'];

            $start_time_HH = $data['time']['HH'];
            $start_time_mm = $data['time']['mm'];
            $start_time = $start_time_HH . ":" . $start_time_mm . ":00";


            $end_time_HH = $start_time_HH;
            $end_time_mm = $start_time_mm + 59;
            if ($end_time_mm > 60) {
                $end_time_mm = $end_time_mm % 60;
                $end_time_HH = $end_time_HH + 1;
            }
            if ($end_time_HH > 24) {
                $end_time_HH = $end_time_HH % 24;
            }

            $end_time = $end_time_HH . ":" . $end_time_mm . ":00";
            $date = $data['date'];
            $date = date('Y-m-d', strtotime($date));

            $userIDs = Bookings::
            join('Rooms', 'Bookings.room_name', '=', 'Rooms.room_name')
                ->join('User_Bookings', 'Bookings.id', '=', 'User_Bookings.id')
                ->where('Bookings.room_name', '=', $room)
                ->where('Bookings.institution_name', '=', $institute)
                ->where(function ($query) use ($end_time, $start_time) {
                    $query->where(function ($query) use ($start_time) {
                        $query->where('Bookings.start_time', '<=', $start_time)
                            ->where('Bookings.end_time', '>=', $start_time);
                    })
                        ->orWhere(function ($query) use ($end_time) {
                            $query->where('Bookings.start_time', '<=', $end_time)
                                ->where('Bookings.end_time', '>=', $end_time);
                        });
                })
                ->where('Bookings.start_date', '=', $date)
                ->select('User_Bookings.user_id')
                ->get();


            $userIDs_array = array();
            foreach ($userIDs as $uID) {

                if (!(in_array($uID->user_id, $userIDs_array))) {
                    $int = $uID->user_id;
                    array_push($userIDs_array, strval($int));

                }
            }

            $userEmails = array();
            foreach ($userIDs_array as $id) {
                $userEmail = User::where('id', $id)->select('email')->first();
                array_push($userEmails, strval($userEmail->email));

            }
            return response()->json([$userEmails]);
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }


}
