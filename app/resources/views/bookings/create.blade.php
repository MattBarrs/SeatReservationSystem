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
                    <form action="{{ route('bookings.index') }}" method="POST">
                        @csrf

                        <label for ="roomCode">Room Code:
                            <div class="tooltip">What's this?
                                <span class="tooltiptext">
                                    Please ask your local admim or staff if you do not the room code
                                </span>
                            </div>
                        </label>
                        <input type="text" id = "roomCode" name = "roomCode">
                        <br/><br/>

                        <label for ="start_time">Pick Start: </label>
                        <input type="datetime-local" id="start_time" name="start_time" min="2020-11-01" max="2030-12-31">
                        <br/><br/>

                        <label for ="end_time">Pick End:</label>
                        <input type="time" id="end_time" name="end_time" min="2020-11-01" max="2030-12-31">



                        <label for ="seat">Choose a seat</label>
                        <select name="seat" id="seat">
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="A3">A3</option>
                            <option value="B1">B1 </option>
                            <option value="B2">B2 </option>
                            <option value="B3">B3 </option>
                        </select>
                        <br/><br/>

                       <fieldset>
                            <label>Extra Requirements</label>
                            <br/>
                            <input type="checkbox" name="extra_requirements[]" id="1" value="Disabled Seat">Disabled Seat<br/>
                            <input type="checkbox" name="extra_requirements[]" id="2" value="Visually Impaired">Visually Impaired<br/>
                        </fieldset>
                        <br/><br/>

                        <input type="submit" value="Submit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


