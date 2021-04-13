<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institution Selection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking">
                <div class="title">Select Institute</div>

                @if( empty($institutes))
                <p>No Institutes Found. Please contact adminastrator </p>
                @else
                    <br/>
                    <form action="{{ route('institution.select') }} " method="POST">
                        @csrf
                        @if( session('institution_name') != null)
                            <h1 style="font-size:20px;"><b>Current Institute Selected: {{ session('institution_name') }}</b></h1>
                        @else
                            <h1 style="font-size:20px;"> No Institute Selected </h1>
                        @endif


                        <select name="institution" id="institution">
                            @foreach($institutes as $institute)
                                <option value="{{$institute->institution_name}}">{{$institute->institution_name}}</option>
                            @endforeach
                        </select>
                        <br/>
                        <label for ="access_code"><p style="font-size:20px;"><b>Access Code<b></p></label>
                        <input type="text" name="access_code" id="access_code"value="{{ old('access_code') }}">

                        @if( session('mssg') != null )
                            <div class = "failAlertMessage" style="text-align:center; max-width:200px;">
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
                        <br/>
                        <input type="submit" value="Submit" class="clickable">
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


