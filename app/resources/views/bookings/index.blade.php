

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper booking-index" >
                    <div class="title"> List of Bookings</div>

                        <div class = "content" style="align-content:center;">
                            @if($bookings == "")
                                <p>No bookings found.</p>
                            @else
                                @foreach($bookings as $booking)
                                <div class="booking-item" style="width:80%;margin-left:auto;margin-right: auto;"  >
                                    <h4>
                                        <a href="/bookings/{{ $booking->id }}">
                                            <table style="margin-left:auto;margin-right: auto;" >
                                                <tr>
                                                    <td style="padding: 0 30px 0 0;" ><img src="/img/workplace.png" alt="booking-item"></td>
                                                    <td style="padding: 0 20px 0 0;" >Room: {{ $booking->room_name }}</td>
                                                    <td style="padding: 0 20px 0 0;" >Seat: {{ $booking->seat_name }}</td>
                                                    <td style="padding: 0 20px 0 0;">Date: {{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                    <td style="padding: 0 20px 0 0;" >
                                                        Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('h:i A') }}
                                                        <br/>
                                                        Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('h:i A') }}
                                                    </td>
                                                    <td>
                                                        <a href="/bookings/{{ $booking->id}}" class="clickable" style="color: #FFFFFFFF">View</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </a>
                                    </h4>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
