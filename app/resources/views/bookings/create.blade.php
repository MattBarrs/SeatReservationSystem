<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking" style="width:80%;">
                <div class="title">Create New Booking</div>
                <br/>
                <p>Room Selected: {{ session('selected_room') }} </p>
                <a href="{{ route('bookings.selectRoom') }}"  class="clickable"> <b>Change room</b></a>


                <form action="{{ route('bookings.create') }}" method="POST">
                    @csrf



                    <label for ="start_date">Pick Date </label>
                    <input type="date" id="start_date" name="start_date" min="2020-11-01" max="2030-12-31" value="{{ old('start_date') }}">

                    @foreach ($errors->get('start_date') as $message)
                    <div class="alert alert-danger">
                        <ul>
                            <li class="failAlertMessage"> {{ $message }}</li>
                        </ul>
                    </div>
                    @endforeach

                    <table style="width:50% align:left;">

                        <tr>
                            <th>  <label for ="start_time">Start Time</label>  </th>
                            <th>     </th>
                            <th>  <label for ="end_time">End Time</label>      </th>
                        </tr>

                        <tr>
                            <th>  <input type="time" id="start_time" name="start_time" min="{{ session('open_time')  }}" max="{{ session('close_time')  }}" value="{{ old('start_time') }}">  </th>
                            <th>     </th>
                            <th>  <input type="time" id="end_time" name="end_time" min="{{ session('open_time') }}" max="{{ session('close_time') }}" value="{{ old('end_time') }}">        </th>
                        </tr>
                    </table>

                    @foreach ($errors->get('start_time') as $message)
                    <div class="alert alert-danger">
                        <ul>
                            <li class="failAlertMessage"> {{ $message }}</li>
                        </ul>
                    </div>
                    @endforeach

                    @foreach ($errors->get('end_time') as $message)
                    <div class="alert alert-danger">
                        <ul>
                            <li class="failAlertMessage"> {{ $message }}</li>
                        </ul>
                    </div>
                    @endforeach

                    <label for ="seat">Choose a seat</label>
                    <select name="seat" id="seat">
                        @foreach ($seats as $seat)
                            <option value="{{$seat->seat_name}}">{{$seat->seat_name}}</option>

                        @endforeach
                    </select>
                    <input type="submit" value="Submit" class="clickable">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


