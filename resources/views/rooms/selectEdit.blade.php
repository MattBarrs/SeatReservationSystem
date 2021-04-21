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


                            <p style="padding-top:10px">Please select a room to edit.</p>

                            @foreach($rooms as $room)
                                <form action=" {{ route('rooms.edit') }} " method="GET" >
                                    <button type="submit" name="submit" value="{{$room->room_name}}" style="width:100%;outline:none;">
                                        <div class="outer-display-item">
                                            <div class="display-item" >
                                                <table class="display-table">
                                                    <tr>
                                                        <td style="padding:5px 20px 10px 30px;" ><img src="/img/roomIcon.png" alt="room-item"></td>
                                                        <td  style="padding:5px 20px 10px 30px;" > {{ $room->room_name }} </td>
                                                        <td style="padding:5px 20px 10px 30px;" >
                                                            Opens: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->open_time)->format('h:i A')}}
                                                            <br/>
                                                            Closes: {{\Carbon\Carbon::createFromFormat('H:i:s',$room->close_time)->format('h:i A')}}
                                                        </td>
                                                        <td style="padding:5px 20px 10px 30px;" >
                                                            <button type="submit" name="submit" value="{{$room->room_name}}" class="clickable">Select</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


