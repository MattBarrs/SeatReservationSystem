<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="wrapper create-booking" style="width:80%;">
                <div class="title">Create Room</div>
                <br/>
                <h1 style="font-size:1.5em"> Current Institute: {{ Session::get('institution_name') }}</h1></h1>
                <uploadroom-component></uploadroom-component>
            </div>
        </div>
    </div>
</x-app-layout>


