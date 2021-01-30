<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book A Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper booking-index">

                    <div class="title">Book A Seat: Select Room</div>

                    @if( empty($rooms))
                        <br/>
                        <div class="alertMessage">No Rooms Found For Your Institute</div>
                        <br/>
                        <h1>Current Institute Selected: {{ session('institution_name') }}</h1>
                        <a href="{{ route('institution.select') }}" class="clickable">Change Institution</a>

                    @else
                        <form action=" {{ route('bookings.selectRoom') }} " method="GET" >
                            @foreach($rooms as $room)
                                <div class="booking-item" >
                                    <h4>
                                        <button type="submit" name="submit" value="{{$room->room_name}}">
                                            <table style="text-align:left;">
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
                                    </h4>
                                </div>
                            @endforeach
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
