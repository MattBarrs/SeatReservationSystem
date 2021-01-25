<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper create-booking">
                    <h1> Create A New Booking</h1>
                    <form action="{{ route('bookings.create') }}" method="GET">
                        @csrf

                        <label for ="institution"></label>
                        <select name="institution" id="institution">
                            <option value="UNIVERSITY OF LEEDS">University of Leeds</option>
                            <option value="LEEDS BECKETT">Leeds Beckett</option>
                            <option value="UNIVERSITY OF SHEFFIELD">University of Sheffield</option>
                        </select>
                        <br/><br/>


                        <input type="submit" value="Submit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


