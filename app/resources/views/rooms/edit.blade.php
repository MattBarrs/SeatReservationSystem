<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="wrapper create-booking">

                <div class="title"> Edit Room Details</div>

                    <div class = "content" style="align-content:center;">
                        <div class = "content" style="align-content:center;">
                                Room Selected: {{$rooms->room_name}}<br/>
                                    <a href="{{ route('rooms.selectEdit') }}" class="clickable">Select Different Room</a>

                                    <form action="{{ route('rooms.delete', $rooms->room_name)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="redButton">Delete Room</button>
                                    </form>



                                    <br/><br/>

                                </div>
                            <createroom-component  image_name="{{$rooms->floor_plan}}"  previouscanvas="{{$rooms->room_canvas}}" style="width:95%"></createroom-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


