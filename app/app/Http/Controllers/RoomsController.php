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
        $institution = $request->session()->get('institution_name');
        $room = Rooms::latest()->get();
        return view
        ('rooms.index',
            [
                'rooms' => $room,
                'open_time' => request('open_time'),
                'close_time' => request('close_time'),
                'bookingCode' => request('bookingCode'),
                'institution_name' => request('institution_name'),
                'referenceLength' => request('referenceLength'),
            ],
        );
    }

    public function show($id)
    {
        $room = Rooms::findOrFail($id);
        return view('rooms.show',['Room' => $room]);
    }

    public function  create(Request $request){
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
        $room = new Rooms();

        $room_name_input = request('room_name');
        $institute = $request->session()->get('institution_name');

        $request->session()->put('selected_room', $room_name_input);

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

        $room->institution_name = $institute;
        $room->room_name = $room_name_input;
        $room->open_time = request('open_time');
        $room->close_time = request('close_time');
        $room->room_details = request('room_details');

        $room->floor_plan = "s"; //For java interactive section
        $room->reference_length = 10.0; //Reference length to allow distance guaging
        //request(file('floor_plan'));

        $room->save();


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
        return redirect('/rooms/edit');
    }

    public function selectEdit(Request $request)
    {
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
            foreach($seats as $seat)
            {
                $inputBoxName = str_replace(' ','_', $seat->seat_name);
                $seat->seat_name = $inputBoxName;
            };
        }


        return view('rooms.edit', ['seats'=>$seats],['rooms'=>$rooms]);
    }

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
            $inputBoxName = str_replace(' ','_', $seat->seat_name);
            $stringForInput = "seatInputFor_$inputBoxName";
            $seat_name_input = request($stringForInput);
            $seat_details = request("detailsFor_$inputBoxName");

            $trial = Workstation::where('room_name',$seat->room_name)
                ->where('institution_name',$seat->institution_name)
                ->where('seat_name',"$seat->seat_name")
                ->get();



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
                echo $seat_name_input;
                echo $seat->seat_name;
                Workstation::
                    where('room_name',$seat->room_name)
                    ->where('institution_name',$seat->institution_name)
                    ->where('seat_name',$seat->seat_name)
                    ->update(['seat_details'=>$seat_details, 'seat_name'=>$seat_name_input]);
            }

        }
        $request->session()->put('selected_room', "");
        $request->session()->put('open_time',"");
        $request->session()->put('close_time',"");

        return redirect('/')->with('mssg','Room Details Updated Successfully');
    }

    public function seatDelete($id){
        $seat = Workstation::findOrFail($id);
        $seat->delete();

        return redirect(route('rooms.edit'));
    }
    public function destroy($id){
        $room = Rooms::findOrFail($id);
        $room->delete();

        return redirect(route('rooms.index'));
    }
}
