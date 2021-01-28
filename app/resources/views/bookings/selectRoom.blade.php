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

                    @if(count($rooms) == 0)
                        <br/>
                        <div class="alertMessage">No Rooms Found For Your Institute</div>
                        <br/>
                        <h1>Current Institute Selected: {{ session('institution_name') }}</h1>
                        <a href="{{ route('institution.select') }}">Change Institution</a>

                    @else
                        <form action=" {{ route('bookings.selectRoom') }} " method="GET" >
                            @foreach($rooms as $room)
                                <div class="booking-item">

                                    <h4>
                                        <button type="submit" name="submit" value="{{$room->room_name}}">
                                            <table>
                                                <tr>
                                                    <td style="padding:0 10px 0 0;"><img src="/img/roomIcon.png" alt="room-item"></td>
                                                    <td style="padding:0 10px 0 10px;"> {{ $room->room_name }} </td>
                                                    <td style="padding:0 10px 0 10px;">
                                                        Opens: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->open_time)->format('h:i A')}}
                                                        <br/>
                                                        Closes: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->close_time)->format('h:i A')}}</td>
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
