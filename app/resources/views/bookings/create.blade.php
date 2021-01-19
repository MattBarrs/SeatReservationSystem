<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper create-booking">
                    <h1> Create A New Booking</h1>
                    <form action="{{ route('bookings.index') }}" method="POST">
                        @csrf

                        <label for ="roomCode">Room Code</label>

                        <input type="text" id = "roomCode" name = "roomCode" value="{{ old('roomCode') }}">
                        <img src="/img/question.png" class="inline" alt="RoomCode Tooltip" title="Please ask your local admim or staff if you do not the room code" style="width:2%;height:2%;"></a>

                        @foreach ($errors->get('roomCode') as $message)
                            <div class="alert alert-danger">
                                <ul>
                                    <li class="failAlertMessage"> {{ $message }}</li>
                                </ul>
                            </div>
                        @endforeach

                        <br/><br/>

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
                                <th>  <input type="time" id="start_time" name="start_time" min="2020-11-01" max="2030-12-31" value="{{ old('start_time') }}">  </th>
                                <th>     </th>
                                <th>  <input type="time" id="end_time" name="end_time" min="2020-11-01" max="2030-12-31" value="{{ old('end_time') }}">        </th>
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
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="A3">A3</option>
                            <option value="B1">B1 </option>
                            <option value="B2">B2 </option>
                            <option value="B3">B3 </option>
                        </select>
                        <br/><br/>

                       <fieldset>
                            <label>Extra Requirements</label>
                            <br/>
                            <input type="checkbox" name="extra_requirements[]" value="Disabled Seat">Disabled Seat<br/>
                            <input type="checkbox" name="extra_requirements[]" value="Visually Impaired">Visually Impaired<br/>
                        </fieldset>
                        <br/><br/>

                        <input type="submit" value="Submit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


