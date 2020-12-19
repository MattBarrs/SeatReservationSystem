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


                    <div class="content">
                        <img src="/img/bookingIcon.png" alt="bookingIcon" height="200px" width="200px">
                        <div class="title m-b-md">
                            Booking System
                        </div>
                        <p class="mssg">{{ session('mssg') }}</p>
                        <a href="{{ route('bookings.create') }}">Book A seat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
