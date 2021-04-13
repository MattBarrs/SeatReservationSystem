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
                        <h1 style="font-size:3em;">Future Bookings</h1>
                        <h1>(Including Today)</h1>
                        @if($futureBookings == "[]")
                            <p>No bookings found.</p>

                        @else
                            @foreach($futureBookings as $booking)
                                <a href="/bookings/{{ $booking->id }}" style="text-decoration:none;color:black;">
                                    <div class="outer-display-item">
                                        <div class="display-item" >
                                            <table class="display-table" style="table-layout: fixed;">
                                                <td style="text-align:left;"><img src="/img/workplace.png" alt="display-item"></td>
                                                <td style="text-align:left;">{{ $booking->room_name }}<br/>{{$booking->institution_name}}</td>
                                                <td style="text-align:left;">Seat: {{ $booking->seat_name }}</td>
                                                <td style="text-align:left;">Date: {{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                <td style="text-align:left;">
                                                    Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('H:i ') }}
                                                    <br/>
                                                    Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('H:i ') }}
                                                </td>
                                                <td style="text-align:center;"><a href="/bookings/{{ $booking->id}}" class="clickable" style="color: #FFFFFFFF">View</a></td>
                                            </table>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif


                        <h1 style="font-size:3em;">Past Bookings</h1>
                        @if($pastBookings == "[]")
                            <p>No bookings found.</p>
                        @else
                            @foreach($pastBookings as $booking)
                            <a href="/bookings/{{ $booking->id }}" style="text-decoration:none;color:black;">
                                <div class="outer-display-item">
                                    <div class="display-item" >
                                        <table class="display-table" style="table-layout: fixed;">
                                            <td style="text-align:left;"><img src="/img/workplace.png" alt="display-item"></td>
                                            <td style="text-align:left;">{{ $booking->room_name }}<br/>{{$booking->institution_name}}</td>
                                            <td style="text-align:left;">Seat: {{ $booking->seat_name }}</td>
                                            <td style="text-align:left;">Date: {{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                            <td style="text-align:left;">
                                                Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('H:i ') }}
                                                <br/>
                                                Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('H:i ') }}
                                            </td>
                                            <td style="text-align:center;"><a href="/bookings/{{ $booking->id}}" class="clickable" style="color: #FFFFFFFF">View</a></td>
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
