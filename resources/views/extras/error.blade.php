<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{$window}}<span class="text-red-600"> -> Error</span>
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center overflow-hidden shadow-sm sm:rounded-lg  m-auto ">
                <div class="px-10 py-4 bg-red-100 border-2 rounded border-gray-400 m-auto ">
                    <h2 class="font-bold text-xl text-red-600">{{$message}}</h2>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>