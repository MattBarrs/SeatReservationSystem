<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book a Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking">
                <div class="wrapper display-index">

                    <div class="title">Select The Room</div>
                        <div class = "content" style="align-content:center;">
                        @if( empty($rooms))
                            <br/>
                            <h1 style="font-size:20px">Current Institute Selected: {{ session('institution_name') }}</h1>
                            <div class="alertMessage" style="margin-left:auto;margin-right: auto;">No Rooms Found For Your Institute</div>
                            <br/>
                            <br/>
                            <a href="{{ route('institution.select') }}" class="clickable" style="text-decoration:none;">Change Institution</a>

                        @else
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
                                                            Opens: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->open_time)->format('H:i ')}}
                                                            <br/>
                                                            Closes: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->close_time)->format('H:i')}}
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
