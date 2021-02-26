<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="wrapper create-booking" style="width:80%;">
                <div class="title">Canvas Sandbox</div>
                <br/>< Before JS><br/>

                <br/>

                <canvas-component></canvas-component>
                <br/>< After JS ><br/>

        </div>
    </div>
</x-app-layout>

