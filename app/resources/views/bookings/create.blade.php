<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking" style="width:80%;">
                <div class="title">Create New Booking</div>
                <br/>
                <p>Room Selected: {{ session('selected_room') }} </p>
                <a href="{{ route('bookings.selectRoom') }}"  class="clickable" > <b>Change room</b></a>



                <br/>
                <br/>
                <br/>

                <bookseat-component roomcanvas="{{$rooms->room_canvas}}" opentime="{{$rooms->open_time}}" closetime="{{$rooms->close_time}}"></bookseat-component>

            </div>
        </div>
    </div>
</x-app-layout>


