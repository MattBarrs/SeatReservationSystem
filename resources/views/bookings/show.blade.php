<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper booking-details">
                <div>
                    <div class="title"><b>{{ $Booking->room_name}}<b/></div>
                    <div class="seat"><b>Seat: </b>{{ $Booking->seat_name}}</div>
                    <div class="start_date"><b> Date: </b> {{ \Carbon\Carbon::parse($Booking->start_date)->format('j F, Y') }}</div>

                    <br/>
                    <div class="start_time"><b>Start Time: </b> {{ \Carbon\Carbon::createFromFormat('H:i:s', $Booking->start_time)->format('H:i') }}</div>
                    <div class="end_time"><b>End Time: </b>{{ \Carbon\Carbon::createFromFormat('H:i:s', $Booking->end_time)->format('H:i') }}</div>

                    <ul>
                        @if($Booking->seat_details != null)
                        <p class="toppings"> Special Requirements:</p>
                        @foreach( $Booking->seat_details as $seat_details )
                        <li>{{$seat_details}}</li>
                        @endforeach
                        @endif
                    </ul>
                    <form action="{{ route('bookings.delete', $Booking->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="redButton">Delete Booking</button>
                    </form>
                </div>
                <br/><br/>
                <a href="{{ route('bookings.index') }} " class="clickable">Back to all bookings</a>
            </div>
        </div>
    </div>
</x-app-layout>
