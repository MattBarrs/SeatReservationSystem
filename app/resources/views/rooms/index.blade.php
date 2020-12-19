

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper booking-index">
                    <div class="title"> List of Rooms</div>
                    @foreach($rooms as $room)
                    <div class="booking-item">
                        <img src="/img/bookingIcon.png" alt="booking-item" style="width:5%;height:5%;">
                        <h4>
                            <a href="/rooms/{{ $room->id }}"> {{ $room->roomName }} - {{$room->close}} </a>
                        </h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
