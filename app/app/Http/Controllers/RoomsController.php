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
        $institue = $request->session()->get('institution_name');

        $rules =
        [
            'room_name' => ['required',Rule::unique('Rooms')->where('institution_name', $institue)],
            'open_time' => 'required',
            'close_time' => 'required|after:open_time',
            'numOfSeats' => 'required',
//            'reference_length' => 'required',
        ];

        $customMessages = [
            'close_time.after' => "Closing time must be after Opening time."
        ];

        $this->validate($request, $rules, $customMessages);

        $room->institution_name = $institue;
        $room->booking_code = "ABC";
        $room->room_name = request('room_name');
        $room->open_time = request('open_time');
        $room->close_time = request('close_time');
        $room->floor_plan = "s"; //For java interactive section
        $room->reference_length = 10.0; //Reference length to allow distance guaging
        //$room->booking_code = request('booking_code');
        //request(file('floor_plan'));
        $room->save();

        $request->session()->put('selected_room', request('room_name'));

        $roomID = Rooms::latest('created_at')->first()->id;
        $numOfSeats = request('numOfSeats');
        for($i = 0;$i<=$numOfSeats;$i++)
        {
            $workstation = new Workstation();

            $workstation->roomID = $roomID;
            $workstation->seatID = $i+1;
            $workstation->coord_x = 0; //used in javascript map
            $workstation->coord_y = 0; //used in javascript map

            $workstation->save();

        }
        return redirect('/rooms/edit');
    }

    public function edit(Request $request)
    {
        $room = $request->session()->get('selected_room');
        $institue = $request->session()->get('institution_name');

        $seats = Rooms::join('Workstations','Workstations.roomID','Rooms.id')
            ->where('room_name',$room)
            ->where('institution_name',$institue)
            ->select('Workstations.*')
            ->get();

        return view('rooms.edit', ['seats'=>$seats]);
    }

    public function saveSeats(Request $request)
    {

        return redirect('/')->with('mssg','Room Created Successfully');
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
