<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institution Selection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="wrapper create-booking">



                    @if( session('institution_name') != null)
                        <h1>Current Institute Selected: {{ session('institution_name') }}</h1>
                    @else
                        <h1>No Institute Selected <br/>Please Select Your Institution</h1>

                    @endif

                    <form action="{{ route('institution.select') }} " method="GET">
                        @csrf

                        <label for ="institution"></label>
                        <select name="institution" id="institution">
                            <option value="UNIVERSITY OF LEEDS">University of Leeds</option>
                            <option value="LEEDS BECKETT">Leeds Beckett</option>
                            <option value="UNIVERSITY OF SHEFFIELD">University of Sheffield</option>
                        </select>
                        <br/><br/>


                        <input type="submit" value="Submit">
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


