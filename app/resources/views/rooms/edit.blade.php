<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper create-booking">
                    <div class="title"> Edit Room Details</div>

                        <div class = "content" style="align-content:center;">
                            <div class="booking-item" style="width:80%;margin-left:auto;margin-right: auto;"  >
                                <form action="{{ route('rooms.index') }}" method="POST">
                                    @csrf


                                    <table style="margin-left:auto;margin-right: auto; " >
                                    <br/>
                                    <tr style="border:1px solid black;">
                                        <td style="padding: 0 20px 0 0;" >
                                            Seat Name
                                        </td>
                                        <td style="padding: 0 20px 0 0;" >
                                            Seat Details
                                        </td>
                                        <td style="padding: 0 20px 0 0;" >
                                            Remove Seat
                                        </td>

                                    </tr>
                                    @foreach($seats as $seat)


                                            <tr style="border:1px solid black;">
                                                <td style="padding: 0 20px 0 0;" >
                                                    Current Name: {{$seat->seatID}}
                                                    <br/>
                                                    <input type="text" id="seatID" placeholder="Seat Name"style="width:70%;">
                                                </td>
                                                <td style="padding: 0 20px 0 0;" >
                                                    <fieldset>
                                                        <input type="checkbox" name="details[]" value="ColourBlindFriendly">Colour Blind Friendly
                                                        <br/>
                                                        <input type="checkbox" name="details[]" value="Computer" checked>Computer
                                                        <br/>
                                                        <input type="checkbox" name="details[]" value="Quiet Desk">Quiet Desk
                                                        <br/>
                                                        <input type="checkbox" name="details[]" value="StandingDesk">Standing Desk
                                                        <br/>
                                                        <input type="checkbox" name="details[]" value="TouchScreen">Touch Screen
                                                        <br/>
                                                        <input type="checkbox" name="details[]" value="VisuallyImpairedFriendly">Visually Impaired Friendly
                                                    </fieldset>
                                                </td>
                                                <td style="padding: 10px 20px 10px 0;" >
                                                    <form action="{{ route('rooms.edit', $seat->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    <button class="clickable">Remove Seat</button>
                                                </td>
                                            </tr>
                                    @endforeach
                                </table>
                            <input type="submit" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


