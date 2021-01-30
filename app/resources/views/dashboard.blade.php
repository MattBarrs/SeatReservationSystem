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
                    <div class="wrapper booking-index">

                        <div class="content" style="align-content:center;" >
                            <div class="title m-b-md"><br/>Booking System</div>
                            @if( session('mssg') != null )
                            <div class = "successAlertMessage"  style="margin-left:auto;margin-right:auto;" >
                                <p class="mssg" >{{ session('mssg') }}</p>
                            </div>
                            @elseif ( session('mssg') == "Booking Creation Failed" )
                            <div class = "failAlertMessage">
                                <p class="mssg">{{ session('mssg') }}</p>
                            </div>
                            @endif
                            <br/>
                            <a href="{{ route('bookings.create') }}" class="clickable">Book A Seat</a>
                            <br/><br/>

                            <br/>

                            <table>
                                <tr>
                                    <td style="padding:0 10px 0 0;">
                                        <div class="booking-item" style="background-color:#eeeeee">
                                            <p>Your Latest Booking</p>
                                            <div class="booking-item">
                                                @if( empty($booking) )
                                                <p> You have no bookings</p>
                                                @else
                                                <a href="/bookings/{{ $booking->id }}">
                                                    <table>
                                                        <tr>
                                                            <td style="padding:0 15px 0 0;" ><img src="/img/workplace.png" alt="booking-item"></td>
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
                                    <td style="padding:0 0 0 10px;">
                                        <div class="booking-item" style="background-color:#eeeeee">
                                            <h1>Current Institute</h1>


                                            <div class="booking-item"  style="text-align:center;">
                                                @if( session('institution_name') != null)
                                                    <h1>{{ session('institution_name') }}</h1>
                                                    <a href="{{ route('institution.select') }}" class="clickable">Change Institution</a>

                                                @elseif( empty($institutes))
                                                    <p>No Institutes Found. Please contact adminastrator </p>
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

                                                        <label for ="seat">Access Code</label>
                                                        <input type="text" name="access_code" id="access_code"value="{{ old('access_code') }}">
                                                        <br/><br/>
                                                        <input type="submit" value="Submit" class="clickable">
                                                    </form>
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
