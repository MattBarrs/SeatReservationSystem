<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking" style="width:80%;">
                <div class="title">Add Institution</div>
                <br/>
                <form action="{{ route('institution.create') }}" method="POST">
                    @csrf

                    <label for ="institution_name">Institution Name</label>
                    <input type="text" id="institution_name" name="institution_name" value="{{ old('institution_name') }}">

                    @foreach ($errors->get('institution_name') as $message)
                    <div class="alert alert-danger">
                        <ul>
                            <li class="failAlertMessage"> {{ $message }}</li>
                        </ul>
                    </div>
                    @endforeach

                    <label for ="seat">Access Code</label>
                    <input type="text" name="access_code" id="access_code"value="{{ old('access_code') }}">
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
            </div>
        </div>
    </div>
</x-app-layout>


