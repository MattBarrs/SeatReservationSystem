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


                    <div class="content" style="align-content:center;" >
                        <div class="title m-b-md">
                            <br/>Booking System
                        </div>

                        @if( session('institution_name') == null)
                            <div class = "alertMessage"  style="margin-left:auto;margin-right:auto;" >
                                <a href="{{ route('institution.select') }} "><p class="mssg" >No Institution selected. Select Institution</p></a>

                            </div>
                        @endif

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
                        <a href="{{ route('bookings.create') }}">Book A seat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
