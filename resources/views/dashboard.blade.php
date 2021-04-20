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
                                <div></div>
                            </th>
                            <th>
                                <br/>
                                <div class="display-block">
                                    <h1 style="font-size:3em;"><b>Current Institute</b></h1>
                                    <div class="display-item" style="border-width:2px;border-radius:5px;border-color:#000000;">
                                        @if( session('institution_name') != null)
                                            <h6 style="font-size:2em;">{{ session('institution_name') }}</h6>
                                            <br/><a href="{{ route('institution.select') }}" class="clickable" style="text-decoration:none;font-colour: #FFFFFF;text-align:center;white-space:nowrap;">Change Institution</a>

                                        @elseif( empty($institutes))
                                            <p>No Institutes Found. Please contact administrator </p>
                                        @else
                                            <b>No Institute Selected <br/>Please Select Your Institution</b>
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
                                                <input type="submit" value="Submit" class="clickable" style="text-decoration:none;font-colour: #FFFFFF;">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </th>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <br/>
                                <div class="display-block">
                                    <h1 style="font-size:3em;"><b><p>Your Latest Booking</p></b></h1>

                                        @if( empty($booking) )
                                            <div class="display-item">
                                                <p> You have no bookings</p>
                                            </div>
                                        @else
                                            <a href="/bookings/{{ $booking->id }}" class="styledLinks" style="text-decoration:none;color:black;">
                                                <div class="display-item">

                                                    <table class="display-table">
                                                        <tr>
                                                            <td><img src="/img/workplace.png" alt="display-item"></td>
                                                            <td class="cellWidth"> {{ $booking->room_name }}</td>
                                                            <td class="cellWidth">Seat: {{ $booking->seat_name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                            <td>
                                                                Starts {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('H:i') }}
                                                                <br/>
                                                                Ends {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('H:i ') }}
                                                            </td>

                                                            <td>
                                                                <a href="/bookings/{{ $booking->id}}" class="clickable" style="text-decoration:none;font-colour: #FFFFFF;">View</a>
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
                                    <br/>
                                    <div class="display-block">
                                        <h1 style="font-size:3em;"><b><p>Upcoming Bookings</p></b></h1>

                                        <div class="display-item" style="border-width:2px;border-radius:5px;border-color:#000000;">

                                            @if( empty($upcoming_bookings) )
                                                <p> You have no upcoming bookings</p>
                                            @else
                                                <a href="{{ route('bookings.index') }}" class="clickable" style="text-decoration:none;font-colour: #FFFFFF;">View All</a>
                                                <br/>
                                                <br/>
                                                @foreach($upcoming_bookings as $booking)
                                                    <a href="/bookings/{{ $booking->id }}" style="text-decoration:none;color:black;">
                                                        <div class="display-item" >
                                                            <table class="display-table">
                                                                <tr>
                                                                    <td><img src="/img/workplace.png" alt="display-item"></td>
                                                                    <td class="cellWidth"> {{ $booking->room_name }}</td>
                                                                    <td class="cellWidth">Seat: {{ $booking->seat_name }}</td>
                                                                    <td class="cellWidth">{{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                                    <td>
                                                                        Start {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->start_time)->format('H:i ') }}
                                                                        <br/>
                                                                        End {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->end_time)->format('H:i ') }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/bookings/{{ $booking->id}}" class="clickable" style="text-decoration:none;font-colour:#00000;">View</a>
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
                        <br/>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
