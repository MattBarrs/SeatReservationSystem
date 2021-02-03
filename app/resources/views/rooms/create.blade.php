<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper create-booking" style="width:80%;">
                    <div class="title"> Add New Room</div>
                    <form action="{{ route('rooms.index') }}" method="POST" style="padding: 0 0 0 30px;">

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
                                <th style="padding: 0 10px 0 0;"> <label for ="open_time">Opening Time</label> </th>
                                <th style="padding: 0 10px 0 0;"> <label for ="close_time">Closing Time</label> </th>
                            </tr>
                            <tr >
                                <td style="padding: 0 10px 0 0;"> <input type="time" name="open_time" id="open_time" value="{{ old('open_time') }}"> </td>
                                <td style="padding: 0 10px 0 0;"> <input type="time" name="close_time" id="close_time" value="{{ old('close_time') }}"> </td>
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
                        <input type="number" id="numOfSeats" name="numOfSeats" min="1" value="{{ old('numOfSeats') }}" style="width:10%;">

                        @foreach ($errors->get('numOfSeats') as $message)
                        <div class="alert alert-danger">
                            <ul>
                                <li class="failAlertMessage"> {{ $message }}</li>
                            </ul>
                        </div>
                        @endforeach


                        <br/><br/>
                        <b>Room Facilities & Details</b>
                        <fieldset>
                            <input type="checkbox" name="room_details[]" value="Catering" @if(is_array(old('room_details')) && in_array('Catering', old('room_details'))) checked @endif>Catering
                            <br/>
                            <input type="checkbox" name="room_details[]" value="DisabledToilets" @if(is_array(old('room_details')) && in_array('DisabledToilets', old('room_details'))) checked @endif>Disabled Toilets
                            <br/>
                            <input type="checkbox" name="room_details[]" value="GuideDogFriendly" @if(is_array(old('room_details')) && in_array('GuideDogFriendly', old('room_details'))) checked @endif>Guide Dog Friendly
                            <br/>
                            <input type="checkbox" name="room_details[]" value="WheelChairAccess" @if(is_array(old('room_details')) && in_array('WheelChairAccess', old('room_details'))) checked @endif>Wheel Chair Access
                            <br/>
                            <input type="checkbox" name="room_details[]" value="Lifts" @if(is_array(old('room_details')) && in_array('Lifts', old('room_details'))) checked @endif>Lifts
                            <br/>
                            <input type="checkbox" name="room_details[]" value="PrayerRooms" @if(is_array(old('room_details')) && in_array('PrayerRooms', old('room_details'))) checked @endif>Prayer Room
                            <br/>
                            <input type="checkbox" name="room_details[]" value="QuietRoom" @if(is_array(old('room_details')) && in_array('QuietRoom', old('room_details'))) checked @endif >Quiet Room
                            <br/>
                            <input type="checkbox" name="room_details[]" value="Toilets" @if(is_array(old('room_details')) && in_array('Toilets', old('room_details'))) checked @endif>Toilets
                            <br/>
                        </fieldset>

                        <label for ="floor_plan">Upload floor plan of room</label>
                        <input type="file" id="floor_plan" name="floor_plan">
                        <br/><br/>

                        <input type="submit" value="Submit" class="clickable">
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


