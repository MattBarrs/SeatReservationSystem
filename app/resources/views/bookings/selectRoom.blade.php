<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book A Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking">
                <div class="wrapper display-index">

                    <div class="title">Select Room</div>
                        <div class = "content" style="align-content:center;">
                        @if( empty($rooms))

                            <div class="alertMessage">No Rooms Found For Your Institute</div>
                            <br/>
                            <h1>Current Institute Selected: {{ session('institution_name') }}</h1>
                            <a href="{{ route('institution.select') }}" class="clickable" style="text-decoration:none;">Change Institution</a>

                        @else
                            <div class="display-block">
                                <input type="checkbox" id="hide-show" style="display:none"  @if(empty(request('submit'))==false) checked @endif s>
                                    <div id="hidden">
                                        <form action=" {{ route('bookings.filterRooms') }} " method="POST">
                                            @csrf

                                            <button type="button" style="margin-right: 100%;white-space:nowrap;">Filter Rooms</button>
                                            <fieldset>
                                                <table  style="border-color:black;border-width:1px; text-align:left;background-color:#eae8e1;">
                                                    <tr>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="Catering" @if(is_array(old('room_details')) && in_array('Catering', old('room_details'))) checked @endif> Catering </td>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="DisabledToilets" @if(is_array(old('room_details')) && in_array('DisabledToilets', old('room_details'))) checked @endif> Disabled Toilets</td>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="GuideDogFriendly" @if(is_array(old('room_details')) && in_array('GuideDogFriendly', old('room_details'))) checked @endif> Guide Dog Friendly</td>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="WheelChairAccess" @if(is_array(old('room_details')) && in_array('WheelChairAccess', old('room_details'))) checked @endif> Wheel Chair Access</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="Lifts" @if(is_array(old('room_details')) && in_array('Lifts', old('room_details'))) checked @endif> Lifts</td>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="PrayerRooms" @if(is_array(old('room_details')) && in_array('PrayerRooms', old('room_details'))) checked @endif> Prayer Room</td>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="QuietRoom" @if(is_array(old('room_details')) && in_array('QuietRoom', old('room_details'))) checked @endif > Quiet Room</td>
                                                        <td style="padding-left: 5px;"><input type="checkbox" name="room_details[]" value="Toilets" @if(is_array(old('room_details')) && in_array('Toilets', old('room_details'))) checked @endif> Toilets</td>
                                                    </tr>
                                                </table>
                                                <div style="white-space:nowrap;margin-right:100%">
                                                    <button type="submit" name="submit" value="submit" class="clickable">Apply</button>

                                                    @if(empty(request('submit'))==false)
                                                        <a href="/bookings/create/rooms" class="clickable" >Clear Filter(s)</a>
                                                    @endif
                                                </div>
                                                @if( $errors->any() )
                                                    <div class = "failAlertMessage"  style="align:left;">
                                                        <p>{{ $errors->first() }}</p>
                                                    </div>
                                                @endif


                                            </fieldset>
                                        </form>
                                    </div>


                                <label for="hide-show" class="clickable" style="margin-top:20px;margin-top:10px;margin-bottom:10px;">Show Filters</label>
                            </div>

                            @if($rooms =="[]" )
                                <div class="display-item">
                                    No Rooms found
                                </div>
                            @else
                                @foreach($rooms as $room)
                                    <form action=" {{ route('bookings.selectRoom') }} " method="GET" >
                                        @csrf
                                            <button type="submit" name="submit" value="{{$room->room_name}}" class="display-table" style="outline:none;">
                                                <div class="display-item">
                                                    <table class="display-table">
                                                        <td><img src="/img/roomIcon.png" alt="room-item"></td>
                                                        <td class="cellWidth"> {{ $room->room_name }} </td>
                                                        <td>
                                                            Opens: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->open_time)->format('h:i A')}}
                                                            <br/>
                                                            Closes: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->close_time)->format('h:i A')}}
                                                        </td>
                                                        <td>
                                                            <button type="submit" name="submit" value="{{$room->room_name}}" class="clickable">Select</button>
                                                        </td>
                                                    </table>
                                                </div>
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
