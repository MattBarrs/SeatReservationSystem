<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex-center position-ref full-height">
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

                            <table style="align-content:center;">
                                <tr style=" text-align:center;width:80%;align:center;">
                                    <td style="padding:0 0 0 10px;">
                                        <div class="dashboard-display-item">
                                            New Booking?
                                            <div class="display-item" style="margin-left:auto;margin-right:auto; text-align:center;width:100%;">
                                                <a href="{{ route('bookings.create') }}" class="clickable" style="width:100%;white-space:nowrap;">Book A Seat</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:0 0 0 10px;">
                                        <div class="dashboard-display-item" style="color:#ffffff">
                                            Current Institute


                                            <div class="display-item"  style="margin-left:auto;margin-right:auto; text-align:center;width:100%;color:#000000">
                                                @if( session('institution_name') != null)
                                                    <h1>{{ session('institution_name') }}</h1>
                                                    <a href="{{ route('institution.select') }}" class="clickable" style="text-align:center;white-space:nowrap;">Change Institution</a>

                                                @elseif( empty($institutes))
                                                    <p>No Institutes Found. Please contact administrator </p>
                                                @else
                                                    <h1>No Institute Selected <br/>Please Select Your Institution</h1>
                                                    <form action="{{ route('institution.select') }} " method="POST">
                                                        @csrf

                                                        <label for ="institution"></label>
                                                        <select name="institution" id="institution">
                                                            @foreach($institutes as $institute)
                                                            <option value="{{$institute->institution_name}}">{{$institute->institution_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <br/><br/>

                                                        <input type="text" name="access_code" id="access_code"value="{{ old('access_code') }}" placeholder="Access Code">
                                                        <br/><br/>
                                                        <input type="submit" value="Submit" class="clickable">
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr style="margin-left:auto;margin-right:auto; text-align:center;width:auto; align:center;" >
                                    <td style="padding:0 10px 0 0;">
                                        <div class="dashboard-display-item">
                                            <p>Your Latest Booking</p>
                                            <div class="display-item" style="margin-left:auto;margin-right:auto; text-align:center;width:100%;color:#000000">
                                                @if( empty($booking) )
                                                <p> You have no bookings</p>
                                                @else
                                                <a href="/bookings/{{ $booking->id }}">
                                                    <table>
                                                        <tr>
                                                            <td style="padding:0 15px 0 0;" ><img src="/img/workplace.png" alt="display-item"></td>
                                                            <td style="padding:0 15px 0 0;">{{ \Carbon\Carbon::parse($booking->start_date )->format('d/m/Y') }}</td>
                                                            <td style="padding:0 15px 0 0;">
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

                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="padding:0 10px 0 0;">
                                        <div class="dashboard-display-item">
                                            <p>Upcoming Bookings</p>
                                            <div class="display-item" style="margin-left:auto;margin-right:auto; text-align:center;width:auto;color:#000000">
                                                @if( empty($upcoming_bookings) )
                                                    <p> You have no upcoming bookings</p>
                                                @else
                                                    @foreach($upcoming_bookings as $booking)
                                                    <div class="display-item" style="border-width:2px;border-radius:5px;border-color:#000000;width:auto;">
                                                            <a href="/bookings/{{ $booking->id }}">
                                                                <table>
                                                                    <tr style="margin-left:auto;margin-right:auto;">
                                                                        <td style="padding: 0 20px 0 0;" ><img src="/img/workplace.png" alt="display-item"></td>
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
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
