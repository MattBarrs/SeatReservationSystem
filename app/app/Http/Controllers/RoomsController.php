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

    public function  createCanvas(Request $request){

    }

    public function saveCanvas(Request $request){
        $institute = $request->session()->get('institution_name');
        $room = $request->session()->get('selected_room');

        $canvasObject = $request('saveCanvasVar');

        Rooms::
            where('room_name',$room)
            ->where('institution_name',$institute)
            ->update('room_canvas',$canvasObject);

        return redirect('/dashboard');


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
//            'numOfSeats' => 'required',
            'floor_plan' => 'required|mimes:jpg,jpeg,png,bmp,pdf',
//            'reference_length' => 'required',
        ];

        $customMessages = [
            'close_time.after' => "Closing time must be after Opening time.",
            'numOfSeats.required' => "The number of seats is required.",
            'floor_plan.required' => "Please upload a floor plan"
        ];

        $this->validate($request, $rules, $customMessages);


        #add data to the room instance
        $room->institution_name = $institute;
        $room->room_name = $room_name_input;
        $room->open_time = request('open_time');
        $room->close_time = request('close_time');
        $room->room_details = request('room_details');

        // Store the record, using the new file hashname which will be it's new filename identity.

        $file = request('floor_plan');
//        $file->store('public');
//        Storage::put('/public/',$file, 'public');


//        $request->file('floor_plan')->store(
//            'floor_plan', 'public'
//        );
        Storage::disk('public')->put('floor_plan', $file,'public');
        $room->floor_plan = $file->HashName();
//       Storage::put('public/floor_plan/', $file, 'public');
//        $contents = Storage::get($room->floor_plan);
//        error_log($room->floor_plan);


//        $filePath = asset("public/floor_plan/"."".$room->floor_plan);
//        Storage::setVisibility($filePath, 'public');
//        error_log(Storage::getVisibility($filePath) );
//        error_log($filePath);
//        $visibility = Storage::getVisibility("public/floor_plan/"."".$imageName);

//        Storage::disk('local')->put($file, 'Contents');
//            $room->floor_plan = "s"; //For java interactive section
        $room->reference_length = 10.0; //Reference length to allow distance guaging
        //request(file('floor_plan'));
        $room->room_canvas = "None";
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
        elseif( $institute == "")
        {
            return redirect('/institution');
        }
        elseif($room == "" ) {
            return redirect('/rooms/selectEdit');
        }
        else
        {
            $rooms  = Rooms::
                    where('institution_name',$institute)
                    ->where('room_name',$room)
                    ->first();

//            $imageName = $rooms->floor_plan;
//            $imageName = "floor_plan/". "". $imageName;
//            $imageName = $imageName;
//            $imageName = "floor_plan/". "". $imageName . "a" ;
//            $imagePath = "/public/floor_plan/"."".$imageName;
            $image = "";
//            asset($imageName);
//            $image = asset('/floor_plan/'."".$imageName);
//                    $filePath = asset("public/floor_plan/"."".$room->floor_plan);

//            error_log($image);
//            $canvasImage = Storage::url('public/'.''.$imageName);
//            var_dump($canvasImage);
//            $canvasURL = Storage::url($imageName);
//            $asset = asset($imageName);
//            error_log($asset);
//            error_log($canvasURL);
//            $visibility = Storage::getVisibility('storage/app/public/'."".$canvasURL);
//            $visibility = Storage::getVisibility($image);
//            error_log($visibility);
            //            error_log("------------------");
//            error_log((string)($canvasImage));
//            $canvasImage = "ASHSH";
//            $request->session()->put('floor_plan',$fileName);

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


        return view('rooms.edit')
            ->with('seats',$seats)
            ->with('rooms',$rooms)
            ->with('image',$image);
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

    #delete a room
    public function destroy($room_name,Request $request){
        $institute = $request->session()->get('institution_name');

        $room = Rooms::
            where('room_name',$room_name)
            ->where('institution_name',$institute);

        $bookings = Bookings::
            where('room_name',$room_name)
            ->where('institution_name',$institute);



        $workstations = Workstation::
            where('room_name',$room_name)
            ->where('institution_name',$institute);

        $user_bookingsSearch = Bookings::
        where('room_name',$room_name)
            ->where('institution_name',$institute)
            ->get();

        foreach($user_bookingsSearch as $booking)
        {
            $user_bookings = User_Booking::
                where('id',$booking->id);
            $user_bookings->delete();
        }

        $workstations->delete();
        $bookings->delete();
        $room->delete();

        #blank the session data
        $request->session()->put('selected_room', "");
        $request->session()->put('open_time',"");
        $request->session()->put('close_time',"");

        return redirect(route('rooms.index'));
    }
}
