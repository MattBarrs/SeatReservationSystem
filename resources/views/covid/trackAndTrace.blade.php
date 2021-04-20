<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper booking-details">
                <div>
                    <trackandtrace-component :institutes="{{ $institutes}}"  :rooms="{{$rooms}}" ></trackandtrace-component>
                    <br/><br/>
            </div>
        </div>
    </div>
</x-app-layout>
