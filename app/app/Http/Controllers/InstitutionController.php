<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function  select(Request $request){
        $institution = $request->session()->get('institution_name');
        $value   = request('institution');

        if( $value == null)
        {
            return view('institution.select');
        }
        else
        {
            $request->session()->put('institution_name', $value);
            return redirect('/dashboard')->with('mssg','Institution Selected Successfully');

        }

    }
}
