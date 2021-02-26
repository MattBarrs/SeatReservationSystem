<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institution Selection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking">
                @if( session('institution_name') != null)
                    <h1>Current Institute Selected: {{ session('institution_name') }}</h1>
                @else
                    <h1>No Institute Selected <br/>Please Select Your Institution</h1>
                @endif

                @if( empty($institutes))
                    <p>No Institutes Found. Please contact adminastrator </p>
                @else
                    <form action="{{ route('institution.select') }} " method="POST">
                        @csrf

                        <label for ="institution"></label>
                        <select name="institution" id="institution">
                            @foreach($institutes as $institute)
                                <option value="{{$institute->institution_name}}">{{$institute->institution_name}}</option>
                            @endforeach
                        </select>
                        <br/>
                        <label for ="access_code">
                            Access Code
                            <div class="tooltip"style="max-width: 20px;max-height: 20px;"> <img src="img/question.png">
                                <span class="tooltiptext">
                                Please ask your local staff or admin if you do not know the access code.
                            </span>
                            </div>
                        </label>

                        <input type="text" name="access_code" id="access_code"value="{{ old('access_code') }}">
                        @if( session('mssg') != null )
                            <div class = "failAlertMessage">
                                <p class="mssg" >{{ session('mssg') }}</p>
                            </div>
                        @endif
                        @foreach ($errors->get('access_code') as $message)
                            <div class="alert alert-danger">
                                <ul>
                                    <li class="failAlertMessage"> {{ $message }}</li>
                                </ul>
                            </div>
                        @endforeach
                        <br/>
                        <input type="submit" value="Submit" class="clickable">
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


