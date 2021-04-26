<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\User_Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Rooms;
use App\Models\Workstation;
use Illuminate\Support\Facades\Storage;



class RoomsController extends Controller
{
    private function checkPermission($request)
    {
        $user = $request->user();
        if($user->id === 1){
            return true;
        }


        $teams = $user->allTeams();
        foreach ($teams as $team) {
            if ($team->name == "Local Admins" and $team->membership != "") {
                if (($team->membership->role == "Local Admin" or $team->membership->role == "Administrator ") and $user->hasTeamPermission($team, 'room:create')) ;
                {
                    return true;
                }
            }
        }
        return false;
    }

    #show selected room
    public function show($id)
    {
        $room = Rooms::findOrFail($id);
        return view('rooms.show',['Room' => $room]);
    }

    #creating a room
    public function  create(Request $request){

        #get users selected institute
        $institution = $request->session()->get('institution_name');

        #if no institute selected then redirect
        if( $institution == null)
        {
            return redirect('/institution');
        }
        else{
            return view('rooms.create');
        }
    }

    public function saveCanvas(Request $request){
        if($this->checkPermission($request) == true){


            #extract the canvas object
            $canvasObject = $request->get('canvas');

            #count number of cirlces/each cirlce is a seat
            $numOfSeats = substr_count($canvasObject, "circle");

            #get institute and room name
            $institute = $request->session()->get('institution_name');
            $room = $request->session()->get('selected_room');

            #attach the canvas to the room
            Rooms::where('institution_name', $institute)->where('room_name', $room)->update(['room_canvas' => $canvasObject]);;
            Workstation::where('room_name', '=', $room)->where('institution_name', '=', $institute)->delete();

            #create instances of seats
            for ($i = 0; $i < $numOfSeats; $i++) {
                $findWorkstation = Workstation::where('room_name', '=', $room)
                    ->where('institution_name', '=', $institute)
                    ->where('seat_name', '=', $i + 1)
                    ->first();
                if ($findWorkstation === null) {
                    $workstation = new Workstation();

                    $workstation->room_name = $room;
                    $workstation->institution_name = $institute;

                    $workstation->seat_name = $i + 1;

                    $workstation->save();
                }

            }


            return response()->json([$request->all()]);
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }

    public function saveRoom(Request $request)
    {
        if($this->checkPermission($request) == true){

            #retrieve post data and convert to string
            $stringData = strval($request['data']);

            $request['data'] = json_decode($stringData, true);
            $data = json_decode($stringData, true);

            #asign to variables
            $open_time = $data['open_time'];
            $close_time = $data['close_time'];
            $room_name = $data['room_name'];
            $room_details = $data['details'];

            #get name and institute data
            $institute = $request->session()->get('institution_name');
            $request->session()->put('selected_room', $room_name);


            #validate the data
            $request->validate([
                'data.room_name' => 'unique:Rooms,room_name',
                //            'data.room_name' => [Rule::unique('Rooms')->where('institution_name', $institute)],
                //            'data.room_name' => ['required|unique:Rooms,[room_name,)'],//            > ['required',],
                'data.open_time' => 'required',
                'data.close_time' => 'required|after:open_time',
                'floor_plan' => 'required|mimes:jpg,jpeg,png,bmp,pdf',
            ]);


            #new instance of room
            $room = new Rooms();

            #add data to the room instance
            $room->institution_name = $institute;
            $room->room_name = $room_name;
            $room->open_time = $open_time;
            $room->close_time = $close_time;
            $room->room_details = $room_details;
            $room->room_canvas = "None";

            #request uesrs uploaded file then store
            $file = $request['floor_plan'];
            $contents = file_get_contents($file->path());
            Storage::disk('public')->put('floor_plan', $file, 'public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $room->floor_plan = $file->HashName();

            #attempt to save room
            try {
                $room->save();
            } catch (Exception $e) {
            }


            return response()->json([$data]);
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }


    #select which room to edit
    public function selectEdit(Request $request)
    {
        if($this->checkPermission($request) == true){
            #ensures the user has an institute selected
            $institute = $request->session()->get('institution_name');

            if( $institute == NULL) {
                return redirect('/institution');
            } else {
                $rooms = Rooms::
                where('institution_name', $institute)
                    ->get();
            }
            return view('rooms.selectEdit', ['rooms'=>$rooms]);
        }
        else{
            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }

    #Once room is selected to edit
    public function edit(Request $request)
    {
        if($this->checkPermission($request) == true) {
            $value = request("submit");

            $institute = $request->session()->get('institution_name');
            $room = $request->session()->get('selected_room');


            if ($value != NULL) {
                $request->session()->put('selected_room', $value);
                return redirect(route('rooms.edit'));
            } elseif ($institute == "") {
                return redirect('/institution');
            } elseif ($room == "") {
                return redirect('/rooms/selectEdit');
            } else {
                $rooms = Rooms::
                where('institution_name', $institute)
                    ->where('room_name', $room)
                    ->first();

                $seats = Workstation::
                where('room_name', $room)
                    ->where('institution_name', $institute)
                    ->get();
            }

            return view('rooms.edit')
                ->with('seats', $seats)
                ->with('rooms', $rooms);
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }

    }

    #edit the seats of a selected room
    public function editSeats(Request $request)
    {
        if ($this->checkPermission($request) == true) {
            $value = request("submit");

            $institute = $request->session()->get('institution_name');
            $room = $request->session()->get('selected_room');


            #checks if the user has selected a room
            if ($value != NULL) {
                $request->session()->put('selected_room', $value);
                return redirect(route('rooms.edit'));
            } elseif ($institute == "") {
                return redirect('/institution');
            } elseif ($room == "") {
                return redirect('/rooms/selectEdit');
            } else {
                $rooms = Rooms::
                where('institution_name', $institute)
                    ->where('room_name', $room)
                    ->first();

                $seats = Workstation::
                where('room_name', $room)
                    ->where('institution_name', $institute)
                    ->get();
            }


            return view('rooms.editseats')
                ->with('seats', $seats)
                ->with('rooms', $rooms);
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }

    #save the details of the seats
    public function saveSeats(Request $request)
    {
        if($this->checkPermission($request) == true) {
            $room = $request->session()->get('selected_room');
            $institute = $request->session()->get('institution_name');

            $seats = Workstation::
            where('room_name', $room)
                ->where('institution_name', $institute)
                ->get();

            foreach ($seats as $seat) {
                $seat_details = request("detailsFor_$seat->seat_name");

                Workstation::
                where('room_name', $seat->room_name)
                    ->where('institution_name', $seat->institution_name)
                    ->where('seat_name', "$seat->seat_name")
                    ->update(['seat_details' => $seat_details]);
            }

            #blank the session data
            $request->session()->put('selected_room', "");
            $request->session()->put('open_time', "");
            $request->session()->put('close_time', "");

            return redirect('/')->with('mssg', 'Room Details Updated Successfully');
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }

    #save the details of the room once the user has inputted the new data
    public function saveEdit(Request $request)
    {
        if($this->checkPermission($request) == true) {
            $room = $request->session()->get('selected_room');
            $institute = $request->session()->get('institution_name');

            $seats = Workstation::
            where('room_name', $room)
                ->where('institution_name', $institute)
                ->get();

            foreach ($seats as $seat) {
                #revert the -'s back to spaces
                $inputBoxName = str_replace(' ', '_', $seat->seat_name);
                $stringForInput = "seatInputFor_$inputBoxName";
                $seat_name_input = request($stringForInput);
                $seat_details = request("detailsFor_$inputBoxName");

                #only update name if a new name has been inputted by user
                if ($seat_name_input == "") {
                    Workstation::
                    where('room_name', $seat->room_name)
                        ->where('institution_name', $seat->institution_name)
                        ->where('seat_name', "$seat->seat_name")
                        ->update(['seat_details' => $seat_details]);
                } else {
                    Workstation::
                    where('room_name', $seat->room_name)
                        ->where('institution_name', $seat->institution_name)
                        ->where('seat_name', $seat->seat_name)
                        ->update(['seat_details' => $seat_details, 'seat_name' => $seat_name_input]);
                }

            }
            #blank the session data
            $request->session()->put('selected_room', "");
            $request->session()->put('open_time', "");
            $request->session()->put('close_time', "");

            return redirect('/')->with('mssg', 'Room Details Updated Successfully');
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }

//    public function workstationDelete($id){
//        #delete a seat/work
//        $seat = Workstation::findOrFail($id);
//        $seat->delete();
//
//        return redirect(route('rooms.edit'));
//    }

    #delete a room
    #deletes the room and all of its corresponing bookings
    public function destroy($room_name,Request $request){
        if($this->checkPermission($request) == true) {
            $institute = $request->session()->get('institution_name');

            $room = Rooms::
            where('room_name', $room_name)
                ->where('institution_name', $institute);

            $bookings = Bookings::
            where('room_name', $room_name)
                ->where('institution_name', $institute);


            $workstations = Workstation::
            where('room_name', $room_name)
                ->where('institution_name', $institute);

            $user_bookingsSearch = Bookings::
            where('room_name', $room_name)
                ->where('institution_name', $institute)
                ->get();

            foreach ($user_bookingsSearch as $booking) {
                $user_bookings = User_Booking::
                where('id', $booking->id);
                $user_bookings->delete();
            }

            $workstations->delete();
            $bookings->delete();
            $room->delete();

            #blank the session data
            $request->session()->put('selected_room', "");
            $request->session()->put('open_time', "");
            $request->session()->put('close_time', "");

            return redirect('/')->with('mssg', 'Room Deleted');
        }else{

            return redirect('/')->with('mssg','You do not have permission to view this.');
        }
    }
}
