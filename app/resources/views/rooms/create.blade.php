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
                    <h1> Create A New Room</h1>
                    <form action="{{ route('rooms.index') }}" method="POST">
                        @csrf

                        <label for ="roomName">Room Name:
                            <div class="tooltip"> What's this?
                                <span class="tooltiptext">
                                    Name of the room so it's easier for people to remember
                                </span>
                            </div>
                        </label>
                        <input type="text" id = "roomName" name = "roomName">
                        <br/><br/>

                        <label for ="open_time">Opening Time:</label>
                        <input type="time" value="08:30:00" name="open_time" id="open_time">

                        <label for ="close_time">Pick Time:</label>
                        <input type="time" value="08:30:00" name="close_time" id="close_time">

                        <label for ="seat">Number Of Seats</label>
                        <input type="number" id="numOfSeats" name="numOfSeats" min="1">

                        <label for ="floor_plan">Upload floor plan of room</label>
                        <input type="file" id="floor_plan" name="floor_plan">

                        <br/><br/>
                        <input type="submit" value="Submit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


