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
                    <h1> Create A New Room</h1>
                    <form action="{{ route('rooms.index') }}" method="POST">
                        @csrf

                        <label for ="room_name">Room Name
                            <div class="tooltip" style="width:2%;height:2%;">
                                <img src="/img/question.png" class="inline" alt="RoomCode Tooltip" title="Please ask your local admim or staff if you do not the room code"></a>
                                <span class="tooltiptext">
                                    Name for the room - So it's easier for people to remember
                                </span>
                            </div>
                        </label>

                        <input type="text" id = "room_name" name = "room_name" value="{{ old('room_name') }}">

                        @foreach ($errors->get('room_name') as $message)
                        <div class="alert alert-danger">
                            <ul>
                                <li class="failAlertMessage"> {{ $message }}</li>
                            </ul>
                        </div>
                        @endforeach

                        <br/><br/>

                        <table style="width:50% align:left;">

                            <tr>
                                <th> <label for ="open_time">Opening Time</label> </th>
                                <th>     </th>
                                <th> <label for ="close_time">Closing Time</label> </th>
                            </tr>
                            <tr>
                                <th> <input type="time" name="open_time" id="open_time" value="{{ old('open_time') }}"> </th>
                                <th>     </th>
                                <th> <input type="time" name="close_time" id="close_time" value="{{ old('close_time') }}"> </th>
                            </tr>
                        </table>

                        @foreach ($errors->get('open_time') as $message)
                        <div class="alert alert-danger">
                            <ul>
                                <li class="failAlertMessage"> {{ $message }}</li>
                            </ul>
                        </div>
                        @endforeach
                        @foreach ($errors->get('close_time') as $message)
                        <div class="alert alert-danger">
                            <ul>
                                <li class="failAlertMessage"> {{ $message }}</li>
                            </ul>
                        </div>
                        @endforeach


                        <label for ="numOfSeats">Number Of Seats</label>
                        <input type="number" id="numOfSeats" name="numOfSeats" min="1" value="{{ old('numOfSeats') }}">

                        @foreach ($errors->get('numOfSeats') as $message)
                        <div class="alert alert-danger">
                            <ul>
                                <li class="failAlertMessage"> {{ $message }}</li>
                            </ul>
                        </div>
                        @endforeach

                        <label for ="floor_plan">Upload floor plan of room</label>
                        <input type="file" id="floor_plan" name="floor_plan">

                        <br/><br/>
                        <input type="submit" value="Submit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


