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
                                    <td>
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
                                    <td>
                                        <div class="py-12">
                                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                                    <div class="wrapper create-booking"  style="text-align:center;">

                                                        @if( session('institution_name') != null)
                                                        <h1>Current Institute: {{ session('institution_name') }}</h1>
                                                        <a href="{{ route('institution.select') }}" class="clickable"">Change Institution</a>
                                                        @else
                                                        <div class = "alertMessage"  style="margin-left:auto;margin-right:auto;width:100%;min-width: 100px;" >
                                                            <p class="mssg">No Institution Selected</p>
                                                        </div>
                                                        <form action="{{ route('institution.select') }} " method="GET"  >
                                                            @csrf
                                                            <label for ="institution"></label>
                                                            <select name="institution" id="institution" style="margin-left: auto;margin-right: auto;">
                                                                <option value="UNIVERSITY OF LEEDS">University of Leeds</option>
                                                                <option value="LEEDS BECKETT">Leeds Beckett</option>
                                                                <option value="UNIVERSITY OF SHEFFIELD">University of Sheffield</option>
                                                            </select>
                                                            <br/>
                                                            <input type="submit" value="Submit">
                                                        </form>
                                                        @endif

                                                    </div>
                                                </div>
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
