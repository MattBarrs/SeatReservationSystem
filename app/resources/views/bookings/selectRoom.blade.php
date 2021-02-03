<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book A Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper display-index">

                    <div class="title">Book A Seat: Select Room</div>

                    @if( empty($rooms))
                        <br/>
                        <div class="alertMessage">No Rooms Found For Your Institute</div>
                        <br/>
                        <h1>Current Institute Selected: {{ session('institution_name') }}</h1>
                        <a href="{{ route('institution.select') }}" class="clickable">Change Institution</a>

                    @else
                        <div class="display-item" style="margin-right: auto;margin-left: auto;">
                            <form action=" {{ route('bookings.filterRooms') }} " method="POST" >
                                @csrf

                                <button type="button" class="filterCollapse">Filter Rooms</button>
                                <fieldset>
                                    <table style="border-color:black;border-width:3px;">
                                        <tr>
                                            <td style="padding: 0 20px 0 0;" ><input type="checkbox" name="room_details[]" value="Catering" @if(is_array(old('room_details')) && in_array('Catering', old('room_details'))) checked @endif> Catering </td>
                                            <td style="padding: 0 20px 0 0;"><input type="checkbox" name="room_details[]" value="DisabledToilets" @if(is_array(old('room_details')) && in_array('DisabledToilets', old('room_details'))) checked @endif> Disabled Toilets</td>
                                            <td style="padding: 0 20px 0 0;"><input type="checkbox" name="room_details[]" value="GuideDogFriendly" @if(is_array(old('room_details')) && in_array('GuideDogFriendly', old('room_details'))) checked @endif> Guide Dog Friendly</td>
                                            <td style="padding: 0 20px 0 0;"><input type="checkbox" name="room_details[]" value="WheelChairAccess" @if(is_array(old('room_details')) && in_array('WheelChairAccess', old('room_details'))) checked @endif> Wheel Chair Access</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="room_details[]" value="Lifts" @if(is_array(old('room_details')) && in_array('Lifts', old('room_details'))) checked @endif> Lifts</td>
                                            <td><input type="checkbox" name="room_details[]" value="PrayerRooms" @if(is_array(old('room_details')) && in_array('PrayerRooms', old('room_details'))) checked @endif> Prayer Room</td>
                                            <td><input type="checkbox" name="room_details[]" value="QuietRoom" @if(is_array(old('room_details')) && in_array('QuietRoom', old('room_details'))) checked @endif > Quiet Room</td>
                                            <td><input type="checkbox" name="room_details[]" value="Toilets" @if(is_array(old('room_details')) && in_array('Toilets', old('room_details'))) checked @endif> Toilets</td>
                                        </tr>
                                    </table>
                                    <button type="submit" name="submit" value="submit" class="clickable" style="margin-top: 10px">Apply Filter</button>
                                    @if(empty(request('submit'))==false)
                                        <a href="/bookings/create/rooms" class="clickable">Clear Filter(s)</a>
                                    @endif

                                @if( $errors->any() )
                                <div class = "failAlertMessage"  style="align:left;">
                                    <p>{{ $errors->first() }}</p>
                                </div>
                                @endif
                                </fieldset>
                            </form>
                        </div>

                        <form action=" {{ route('bookings.selectRoom') }} " method="GET" >
                            @csrf
                            @if($rooms =="[]" )
                                <div class="display-item" style="margin-left:auto;margin-right: auto;">
                                    No Rooms found
                                </div>
                            @else
                                @foreach($rooms as $room)
                                <div class="display-item" style="margin-left:auto;margin-right: auto;">
                                    <div class="display-item_list" style="margin-left:auto;margin-right: auto;">

                                        <button type="submit" name="submit" value="{{$room->room_name}}">
                                            <table style="content-align:center;text-align:center;width:auto;">
                                                <tr>
                                                    <td style="padding:0 15px 0 0;width:150px;"><img src="/img/roomIcon.png" alt="room-item"></td>
                                                    <td style="padding:0 15px 0 0;width:150px;"> {{ $room->room_name }} </td>
                                                    <td style="padding:0 15px 0 0;width:150px;">
                                                        Opens: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->open_time)->format('h:i A')}}
                                                        <br/>
                                                        Closes: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->close_time)->format('h:i A')}}
                                                    </td>
                                                    <td style="padding:0 15px 0 10px;min-width:150px;max-width:151px;">
                                                        <button type="submit" name="submit" value="{{$room->room_name}}" class="clickable">Select</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @endif


                         </form>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
