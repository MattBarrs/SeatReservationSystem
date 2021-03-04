<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper display-index">

                <div class="title"> Edit Room Details</div>

                    <div class = "content" style="align-content:center;">
                        <div class = "content" style="align-content:center;">
                            <div class="display-item"  style="border-width:2px;border-radius:5px;border-color:#000000;">
                                Room Selected: {{$rooms->room_name}}<br/>

                                    <a href="{{ route('rooms.selectEdit') }}" class="clickable">Select Different Room</a>
                                    <form action="{{ route('rooms.edit') }}" method="POST">
                                        @csrf
                                        <table style="margin-left:auto;margin-right: auto;text-align:left;vertical-align:middle;" >
                                            <br/>
                                            <tr style="border:1px solid black;">
                                                <td style="padding: 0 20px 0 0;" >
                                                    Seat
                                                </td>
                                                <td style="padding: 0 20px 0 0;width:30%;" >
                                                    Seat Details
                                                </td>
                                                <td style="padding: 0 20px 0 0;width:40%;" >
                                                    Accessibility
                                                </td>

                                            </tr>
                                            @foreach($seats as $seat)
                                                <tr style="border:1px solid black;">
                                                    <td style="padding: 0 20px 0 0;" >
                                                        Current Name: {{ str_replace("_"," ", $seat->seat_name) }}
                                                        <br/>
                                                        New Name: <input type="text" id="{{$seat->seat_name}}" name="seatInputFor_{{$seat->seat_name}}" placeholder="Seat Name"style="width:50%;">
                                                    </td>
                                                    <fieldset>
                                                        <td style="padding: 0 20px 0 0;" >
                                                            <input type="checkbox" name="detailsFor_{{$seat->seat_name}}[]" value="Computer" checked> Computer
                                                            <br/>
                                                            <input type="checkbox" name="detailsFor_{{$seat->seat_name}}[]" value="TouchScreen" @if(is_array(old('detailsFor_{{$seat->seat_name}}')) && in_array('TouchScreen', old('detailsFor_{{$seat->seat_name}}'))) checked @endif> Touch Screen
                                                            <br/>
                                                            <input type="checkbox" name="detailsFor_{{$seat->seat_name}}[]" value="StandingDesk"@if(is_array(old('detailsFor_{{$seat->seat_name}}')) && in_array('StandingDesk', old('detailsFor_{{$seat->seat_name}}'))) checked @endif> Standing Desk
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="detailsFor_{{$seat->seat_name}}[]" value="ColourBlindFriendly" @if(is_array(old('detailsFor_{{$seat->seat_name}}')) && in_array('ColourBlindFriendly', old('detailsFor_{{$seat->seat_name}}'))) checked @endif> Colour Blind Friendly
                                                            <br/>
                                                            <input type="checkbox" name="detailsFor_{{$seat->seat_name}}[]" value="VisuallyImpairedFriendly" @if(is_array(old('detailsFor_{{$seat->seat_name}}')) && in_array('VisuallyImpairedFriendly', old('detailsFor_{{$seat->seat_name}}'))) checked @endif> Visually Impaired Friendly
                                                            <br/>
                                                        </td>

                                                    </fieldset>

                                                </tr>
                                            @endforeach
                                        </table>
                                        <br/>
                                        <input type="submit" value="Submit" class="clickable">
                                    </form>
                                    <br/><br/>
                                    <form action="{{ route('rooms.delete', $rooms->room_name)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="redButton">Delete Room</button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


