<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="wrapper create-booking">
                <div class="title">Sandbox</div>
                <br/>< Before JS><br/>

                <br/>
<!--                <canvas-component></canvas-component>-->
<!--                <createroom-component></createroom-component>-->
<!--                <showCanvas-component input_roomcanvas="{{$rooms->room_canvas}}"></showCanvas-component>-->
<!--                    <datetime-component roomcanvas="{{$rooms->room_canvas}}"></datetime-component>-->

                <bookseat-component roomcanvas="{{$rooms->room_canvas}}" opentime="{{$rooms->open_time}}" closetime="{{$rooms->close_time}}"></bookseat-component>
                <br/>< After JS ><br/>

        </div>
    </div>
</x-app-layout>

