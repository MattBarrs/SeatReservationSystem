<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex-center position-ref full-height" style="align-content: middle">


                    <div class="content" >
                        <a href="{{ route('bookings.create') }}"><img src="/img/bookingIcon.png" alt="bookingIcon" height="200px" width="200px" style="margin-left:auto;margin-right:auto"></a>
                        <div class="title m-b-md">
                            <br/>Booking System
                        </div>

                        @if( session('mssg') == "Booking Created Successfully" )
                            <div class = "successAlertMessage"  style="margin-left:auto;margin-right:auto;" >
                                <p class="mssg" >{{ session('mssg') }}</p>
                            </div>
                        @elseif ( session('mssg') == "Booking Creation Failed" )
                            <div class = "failAlertMessage">
                                <p class="mssg">{{ session('mssg') }}</p>
                            </div>
                        @endif
                        <br/>
                        <a href="{{ route('bookings.create') }}">Book A seat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
