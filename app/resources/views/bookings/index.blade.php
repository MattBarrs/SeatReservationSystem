<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper display-index" >

                <div class="title"> List of Bookings</div>

                    <div class = "content" style="align-content:center;">

                        @if($bookings == "[]")
                            <p>No bookings found.</p>

                        @else
                            @foreach($bookings as $booking)
                                <a href="/bookings/{{ $booking->id }}">
                                    <div class="outer-display-item">
                                        <div class="display-item" >
                                            <table class="display-table">
                                                <td style="padding:5px 20px 10px 30px;" ><img src="/img/workplace.png" alt="display-item"></td>
                                                <td style="padding:5px 20px 10px 30px;" >{{ $booking->room_name }}</td>
                                                <td style="padding:5px 20px 10px 30px;" >Seat: {{ $booking->seat_name }}</td>
                                                <td style="padding:5px 20px 10px 30px;white-space: nowrap;">Date: {{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                <td style="padding:5px 20px 10px 30px;white-space: nowrap;" >
                                                    Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('h:i A') }}
                                                    <br/>
                                                    Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('h:i A') }}
                                                </td>
                                                <td>
                                                    <a href="/bookings/{{ $booking->id}}" class="clickable" style="color: #FFFFFFFF">View</a>
                                                </td>
                                            </table>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
