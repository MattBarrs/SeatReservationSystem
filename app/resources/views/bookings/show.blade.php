<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper booking-details">
                    <div>
                        <div class="title"  > Booking in room - {{ $Booking->room_name}}</div>
                        <p class="seat"> Seat - {{ $Booking->seat_name}}</p>
                        <p class="start_date"> Start Date - {{ $Booking->start_time}}</p>
                        <p class="end_time"> End Time - {{ $Booking->end_time}}</p>
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
                            <button class="clickable">Delete Booking</button>
                        </form>
                    </div>
                    <br/><br/>
                    <a href="{{ route('bookings.index') }} " class="clickable">Back to all bookings</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
