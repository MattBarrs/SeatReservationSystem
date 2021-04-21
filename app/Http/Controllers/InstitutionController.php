<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Institution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InstitutionController extends Controller
{
    #when user is selecting an institution
    public function select()
    {
        $institutes_all = Institution::select('institution_name')->orderBy('institution_name','ASC')->get();
        return view('institution.select', ['institutes'=>$institutes_all]);
    }

    #save the users selection
    public function save(Request $request)
    {
        $institute_input = request('institution');

        #access code is a string used to reduce unauthorised access
        $accessCode_input = request('access_code');

        #get the selected institutes access code
        $accessCode_hashed = Institution::where('institution_name',$institute_input)
            ->select('access_code')
            ->first();

        #check that the access code hashes match
        $accessCode_hashed = $accessCode_hashed->access_code ;
        $hashCheck = Hash::check($accessCode_input,$accessCode_hashed);


        if($hashCheck) #if they match
        {
            #save their selection
            $request->session()->put('institution_name', $institute_input);

            #blank other session data
            $request->session()->put('close_time', null);
            $request->session()->put('open_time', null);
            $request->session()->put('close_time', null);
            $request->session()->put('selected_room', null);

            return redirect('/dashboard')->with('mssg', 'Institution Selected Successfully');
        }
        else{   #if  hashes dont match
            return redirect('/institution')->with('mssg', 'Access Code Incorrect');
        }

    }

    #creating a new instance of an institute
    public function create(Request $request)
    {
        return view('institution.create');
    }

    #store the institute being created
    public function store(Request $request)
    {
        $institute = request('institution_name');

        #validation rules
        $rules = [
            'institution_name' => ['max:30','min:5','required',
                                    Rule::unique('Institutions')->where('institution_name', $institute)
                                    ],
            'access_code' => 'required|max:15|min:5',
            'start_time' => 'required',
            'interval_time' => 'required',
        ];


        $customMessages = [
            'institution_name.required' => "Institution Name is required.",
            'access_code.required' => "Access code is required.",
            'access_code.min' => "Code must be at least 5 characters long.",
            'access_code.max' => "Code cannot be longer than 15 characters.",


        ];

        $this->validate($request,$rules,$customMessages);

        #create instance, hash access code
        #hash is stored - NOT PASSWORD
        $institution = new Institution();
        $access_code_hashed = Hash::make(request('access_code'));

        $institution->institution_name = $institute;
        $institution->access_code = $access_code_hashed;

        #start_time is when bookings will start
        $input_sTime = request('start_time');

        #minimum length bookings can take places
        $input_inTime = request('interval_time'); //60 seconds per minute

        $converted_start = ($input_sTime); //60 seconds per minute
        $converted_interval = ($input_inTime);

        $institution->start_time = $converted_start;
        $institution->interval_time = $converted_interval;

        $institution->save();

        return redirect('/dashboard')->with('mssg',"Institution Added Successfully");

    }
}
