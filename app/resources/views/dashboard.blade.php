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



                        @if( session('mssg') != null )
                            <div class = "successAlertMessage"  style="margin-left:auto;margin-right:auto;" >
                                <p class="mssg" >{{ session('mssg') }}</p>
                            </div>
                        @elseif ( session('mssg') == "Booking Creation Failed" )
                            <div class = "failAlertMessage">
                                <p class="mssg">{{ session('mssg') }}</p>
                            </div>
                        @endif

                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                    <div class="wrapper create-booking"  style="text-align:center;">

                                        @if( session('institution_name') != null)
                                            <h1>Current Institute: {{ session('institution_name') }}</h1>
                                        @else
                                            <div class = "alertMessage"  style="margin-left:auto;margin-right:auto;" >
                                                <p class="mssg" >No Institution selected</p>
                                            </div>
                                        @endif

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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/>
                        <a href="{{ route('bookings.create') }}">Book A seat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
