<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper booking-details">
                    <div>
                        <div class="title"  > Room - {{ $Room->room_name}}</div>
                        <p class="opens"> Opens - {{ $Room->open_time }}</p>
                        <p class="closes"> Closes - {{ $Room->close_time }}</p>
                    </div>
                    <a href="{{ route('rooms.index') }} " class="back"> <- Back to all Rooms</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
