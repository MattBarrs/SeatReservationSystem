<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto bg-white shadow-xl sm:rounded-lg flex-center position-ref">

            <div class="wrapper display-index">

                <div class="content" style="align-content:center;" >
                    @if( session('mssg') != null )
                        <div class = "successAlertMessage"  style="margin-left:auto;margin-right:auto;" >
                            <p class="mssg" >{{ session('mssg') }}</p>
                        </div>
                    @endif

                    @if( $errors->any() )
                        <div class = "failAlertMessage"  style="margin-left:auto;margin-right:auto;">
                            <p>{{ $errors->first() }}</p>
                        </div>
                    @endif



                    <table style="margin-top:auto;margin-bottom:auto;">
                        <thead>
                        <tr>
                            <th>
                                <div class="display-block">
                                    New Booking?
                                    <div class="display-item" style="border-width:2px;border-radius:5px;border-color:#000000;">
                                        <a href="{{ route('bookings.create') }}" class="clickable" style="width:100%;white-space:nowrap;">Book A Seat</a>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <div class="display-block">
                                    Current Institute
                                    <div class="display-item" style="border-width:2px;border-radius:5px;border-color:#000000;">
                                        @if( session('institution_name') != null)
                                            <h1>{{ session('institution_name') }}</h1>
                                            <a href="{{ route('institution.select') }}" class="clickable" style="text-align:center;white-space:nowrap;">Change Institution</a>

                                        @elseif( empty($institutes))
                                            <p>No Institutes Found. Please contact administrator </p>
                                        @else
                                            <h1>No Institute Selected <br/>Please Select Your Institution</h1>
                                            <form action="{{ route('institution.select') }} " method="POST" style=" border-width:2px;border-radius:5px;border-color:#000000;">
                                                @csrf

                                                <label for ="institution"></label>
                                                <select name="institution" id="institution" style="margin-top:10px;">
                                                    @foreach($institutes as $institute)
                                                    <option value="{{$institute->institution_name}}">{{$institute->institution_name}}</option>
                                                    @endforeach
                                                </select>
                                                <br/>
                                                <input type="text" name="access_code" id="access_code"value="{{ old('access_code') }}" placeholder="Access Code" style="margin-top:10px;">
                                                <br/>
                                                <input type="submit" value="Submit" class="clickable" style="margin-top:10px;">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </th>
                            <th rowspan="2">

                                <div class="display-block">
                                    <p>Room Last Used</p>
                                    <div class="display-item" style="margin-left:auto;margin-right:auto; text-align:center;height:100%;">
                                        <p style="padding: 125px 10px 100px 10px;">IMAGE OF ROOM</p>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="display-block">
                                    <p>Your Latest Booking</p>

                                        @if( empty($booking) )
                                            <div class="display-item">
                                                <p> You have no bookings</p>
                                            </div>
                                        @else
                                            <a href="/bookings/{{ $booking->id }}">
                                                <div class="display-item">

                                                    <table class="display-table">
                                                        <tr>
                                                            <td><img src="/img/workplace.png" alt="display-item"></td>
                                                            <td>{{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                            <td>
                                                                Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('h:i A') }}
                                                                <br/>
                                                                Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('h:i A') }}
                                                            </td>
                                                            <td>
                                                                <a href="/bookings/{{ $booking->id}}" class="clickable" style="color: #FFFFFFFF">View</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </a>
                                        @endif
                                </div>
                            </td>
                        </tr>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <div class="display-block">
                                        <p>Upcoming Bookings</p>

                                        <div class="display-item" style="border-width:2px;border-radius:5px;border-color:#000000;">

                                            @if( empty($upcoming_bookings) )
                                                <p> You have no upcoming bookings</p>
                                            @else
                                                <a href="{{ route('bookings.index') }}" class="clickable">View All</a>

                                                @foreach($upcoming_bookings as $booking)
                                                    <a href="/bookings/{{ $booking->id }}" style="stext-decoration:none;">
                                                        <div class="display-item" >
                                                            <table class="display-table">
                                                                <tr>
                                                                    <td><img src="/img/workplace.png" alt="display-item"></td>
                                                                    <td class="cellWidth"> {{ $booking->room_name }}</td>
                                                                    <td class="cellWidth">Seat: {{ $booking->seat_name }}</td>
                                                                    <td class="cellWidth">Date {{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                                    <td>
                                                                        Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('h:i A') }}
                                                                        <br/>
                                                                        Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('h:i A') }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/bookings/{{ $booking->id}}" class="clickable" style="color: #FFFFFFFF">View</a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
