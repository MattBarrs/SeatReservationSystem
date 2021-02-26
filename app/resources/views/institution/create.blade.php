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


                    <label for ="start_time">Start Time
                    <div class="tooltip"style=""> <img src="../img/question.png">
                        <span class="tooltiptext">
                                    Start time is when your bookings start.
                                    <br/>
                                        For Example
                                        <br/> 0 would be 9:00, 10:00, 11:00
                                        <br/> 5 would be 9:05, 10:05, 11:05


                        </span>
                    </div>
                    </label>
                    <input v-model="startTimeInput" v-on:change="timeConvert()" type="number" name="start_time" id="start_time" value="{{ old('start_time') }}" min="0" max="3540" step="60">
                    <br/>
                    <div class = "inline">
                        <span v-html="startTimeMinutes" class="inline"></span>
                        <p class="inline">  Minutes Past The Hour</p>
                    </div>

                    @foreach ($errors->get('start_time') as $message)
                    <div class="alert alert-danger">
                        <ul>
                            <li class="failAlertMessage"> {{ $message }}</li>
                        </ul>
                    </div>
                    @endforeach


                    <label for ="interval_time">Interval Time
                        <div class="tooltip"style="max-width: 20px;max-height: 20px;"> <img src="../img/question.png">
                            <span class="tooltiptext">
                                    Interval Time is the intermission in booking times.
                                    <br/>
                                        For Example
                                        <br/> 10 would give 9:00, 9:10, 9:20, 9:30...
                                        <br/> 20 would give 9:20, 9:40, 10:00, 10:20...


                        </span>
                        </div>
                    </label>

                    <input v-model="intervalTimeInput" v-on:change="timeConvert(interval_time)" type="number" name="interval_time" id="interval_time" value="{{ old('interval_time') }}" min="300" max="3540" step="300">

                    <br/>
                    <div class="inline">
                       <span v-html="intervalTimeMinutes" class="inline" ></span><p class="inline"> Minute Divisions</p>
                    </div>

                    @foreach ($errors->get('interval_time') as $message)
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


