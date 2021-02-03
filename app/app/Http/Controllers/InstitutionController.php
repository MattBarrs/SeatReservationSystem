<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Institution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InstitutionController extends Controller
{
    public function select()
    {
        $institutes_all = Institution::select('institution_name')->orderBy('institution_name','ASC')->get();
        return view('institution.select', ['institutes'=>$institutes_all]);
    }

    public function save(Request $request)
    {
        $institute_input = request('institution');

        $accessCode_input = request('access_code');

        $accessCode_hashed = Institution::where('institution_name',$institute_input)
            ->select('access_code')
            ->first();

        $accessCode_hashed = $accessCode_hashed->access_code ;
        $hashCheck = Hash::check($accessCode_input,$accessCode_hashed);
        if($hashCheck)
        {
            $request->session()->put('institution_name', $institute_input);

            $request->session()->put('close_time', null);
            $request->session()->put('open_time', null);
            $request->session()->put('close_time', null);
            $request->session()->put('selected_room', null);

            return redirect('/dashboard')->with('mssg', 'Institution Selected Successfully');
        }
        else{
            return redirect('/institution')->with('mssg', 'Access Code Incorrect');
        }

    }

    public function create(Request $request)
    {
        return view('institution.create');
    }

    public function store(Request $request)
    {
        $institute = request('institution_name');

        $rules = [
            'institution_name' => ['required',Rule::unique('Institutions')->where('institution_name', $institute)],
            'access_code' => 'required|max:15|min:5',
        ];


        $customMessages = [
            'institution_name.required' => "Institution Name is required.",
            'access_code.required' => "Access code is required.",
            'access_code.min' => "Code must be at least 5 characters long.",
            'access_code.max' => "Code cannot be longer than 15 characters.",


        ];

        $this->validate($request,$rules,$customMessages);

        $institution = new Institution();
        $access_code_hashed = Hash::make(request('access_code'));

        $institution->institution_name = $institute;
        $institution->access_code = $access_code_hashed;


        $institution->save();

        return redirect('/dashboard')->with('mssg',"Institution Added Successfully");

    }
}
