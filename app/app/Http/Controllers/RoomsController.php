<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Rooms;
use App\Models\Workstation;

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        #find list of rooms for the institute
        $institution = $request->session()->get('institution_name');

        $room = Rooms::latest()
                ->where('institution_name',$institution)
                ->get();

        return view
        ('rooms.index',['rooms' => $room]);
    }

    #show selected room
    public function show($id)
    {
        $room = Rooms::findOrFail($id);
        return view('rooms.show',['Room' => $room]);
    }

    #creating a room
    public function  create(Request $request){
        #ensures user has an institution selected
        $institution = $request->session()->get('institution_name');

        if( $institution == null)
        {
            return redirect('/institution');
        }
        else{
            return view('rooms.create');
        }
    }

    public function saveRoom(Request $request)
    {
        #new instance of room
        $room = new Rooms();

        #get name and institute data
        $room_name_input = request('room_name');
        $institute = $request->session()->get('institution_name');

        $request->session()->put('selected_room', $room_name_input);

        #validation rules
        $rules =
        [
            'room_name' => ['required',Rule::unique('Rooms')->where('institution_name', $institute)],
            'open_time' => 'required',
            'close_time' => 'required|after:open_time',
            'numOfSeats' => 'required',
//            'reference_length' => 'required',
        ];

        $customMessages = [
            'close_time.after' => "Closing time must be after Opening time.",
            'numOfSeats.required' => "The number of seats is required.",
        ];

        $this->validate($request, $rules, $customMessages);

        #add data to the room instance
        $room->institution_name = $institute;
        $room->room_name = $room_name_input;
        $room->open_time = request('open_time');
        $room->close_time = request('close_time');
        $room->room_details = request('room_details');

        $room->floor_plan = "s"; //For java interactive section
        $room->reference_length = 10.0; //Reference length to allow distance guaging
        //request(file('floor_plan'));

        #save room
        $room->save();

        #create an instance of workstation/seats specified by the user
        $numOfSeats = request('numOfSeats');
        for($i = 0;$i<$numOfSeats;$i++)
        {
            $workstation = new Workstation();

            $workstation->room_name = $room_name_input;
            $workstation->institution_name = $institute;

            $workstation->seat_name = $i+1;
            $workstation->coord_x = 0; //used in javascript map
            $workstation->coord_y = 0; //used in javascript map

            $workstation->save();

        }
        #redirected to edit room so the user can edit details about the workstations
        return redirect('/rooms/edit');
    }

    #select which room to edit
    public function selectEdit(Request $request)
    {
        #ensures the user has an institute selected
        $institute = $request->session()->get('institution_name');

        if( $institute == NULL)
        {
            return redirect('/institution');
        }
        else
        {
            $rooms = Rooms::
                where('institution_name', $institute)
                ->get();
        }
        return view('rooms.selectEdit', ['rooms'=>$rooms]);
    }

    #Once room is selected to edit
    public function edit(Request $request)
    {
        $value   = request("submit");

        $institute = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');

        $seats = "";

        if($value != NULL)
        {
            $request->session()->put('selected_room',$value);
            return redirect(route('rooms.edit'));
        }
        elseif( $institute == NULL)
        {
            return redirect('/institution');
        }
        elseif($room == NULL ) {

            return redirect('/rooms/selectEdit');
        }
        else
        {
            $rooms  = Rooms::
                    where('institution_name',$institute)
                    ->where('room_name',$room)
                    ->first();

            $seats = Workstation::
                    where('room_name',$room)
                    ->where('institution_name',$institute)
                    ->get();
            #spaces are converted to - so they can be names in the HTML form
            foreach($seats as $seat)
            {
                $inputBoxName = str_replace(' ','_', $seat->seat_name);
                $seat->seat_name = $inputBoxName;
            };
        }


        return view('rooms.edit', ['seats'=>$seats],['rooms'=>$rooms]);
    }

    #save the details of the room once the user has inputted the new data
    public function saveEdit(Request $request)
    {
        $room = $request->session()->get('selected_room');
        $institute = $request->session()->get('institution_name');

        $seats = Workstation::
            where('room_name',$room)
            ->where('institution_name',$institute)
            ->get();

        foreach($seats as $seat)
        {
            #revert the -'s back to spaces
            $inputBoxName = str_replace(' ','_', $seat->seat_name);
            $stringForInput = "seatInputFor_$inputBoxName";
            $seat_name_input = request($stringForInput);
            $seat_details = request("detailsFor_$inputBoxName");

            #only update name if a new name has been inputted by user
            if ($seat_name_input == "")
            {
                Workstation::
                    where('room_name',$seat->room_name)
                    ->where('institution_name',$seat->institution_name)
                    ->where('seat_name',"$seat->seat_name")
                    ->update(['seat_details'=>$seat_details]);
            }
            else
            {
                Workstation::
                    where('room_name',$seat->room_name)
                    ->where('institution_name',$seat->institution_name)
                    ->where('seat_name',$seat->seat_name)
                    ->update(['seat_details'=>$seat_details, 'seat_name'=>$seat_name_input]);
            }

        }
        #blank the session data
        $request->session()->put('selected_room', "");
        $request->session()->put('open_time',"");
        $request->session()->put('close_time',"");

        return redirect('/')->with('mssg','Room Details Updated Successfully');
    }

    public function workstationDelete($id){
        #delete a seat/work
        $seat = Workstation::findOrFail($id);
        $seat->delete();

        return redirect(route('rooms.edit'));
    }

    public function destroy($id){
        #delete a room
        $room = Rooms::findOrFail($id);
        $room->delete();

        return redirect(route('rooms.index'));
    }
}
