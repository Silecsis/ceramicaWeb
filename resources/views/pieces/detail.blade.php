<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pieza en detalle') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl m-auto sm:px-6 lg:px-8 ">

            <div class="bg-white py-4 px-4 rounded border-2 border-gray-300 mb-6">
                <div class="flex bg-blue-400 rounded pt-4">
                    <h4 class="pb-4 m-auto text-white font-bold text-lg">{{$piece->name}}</h4>
                </div>
            </div> 

            <div>
                <div class="flex justify-center space-y-1 ">
                    <div class="bg-white rounded p-4">
                        <img alt="imagen pieza"  class="ml-1 rounded  h-80 mr-4 shadow-lg" src="{{ route('image.file', ['filename'=>$piece->img])}}">
                    </div>
                </div>
                <div class="bg-white rounded p-4 mt-4">
                   <p><span class="font-bold text-black">·Nombre de la pieza: </span>
                   {{$piece->name}}</p>
                   <p><span class="font-bold text-black">·Descripción: </span>
                   {{$piece->description}}</p>
                   <p><span class="font-bold text-black">·Autor: </span>
                   {{$user->name}} (<span class="font-bold text-yellow-500"> {{$user->email}}</span>)</p>
                   <p><span class="font-bold text-black">·Estado de venta: </span>
                        @if($piece->sold == 0)
                        <span>Aún en venta.</span>
                        @else
                            <span class="font-bold text-green-600">Vendida</span>.
                        @endif
                   </p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <a href="javascript:history.back()"  
                        class="px-4 py-2 bg-gray-800 rounded-md font-bold tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150
                                flex text-white font-bold bg-blue-400 p-4 rounded p-1.5">
                                Volver
                    </a>
                </div>

                <div class="mt-6 bg-white mb-6 overflow-hidden shadow-sm sm:rounded-lg  border-2 border-gray-400 p-4">
                    <div class="flex bg-blue-400 rounded p-4 rounded border-2">
                        <h4 class="m-auto text-white font-bold text-lg">Materiales empleados en la pieza</h4>
                    </div>
                    <table class=" w-full ">
                        <thead class="bg-blue-300">
                            <tr class="divide-x">
                                <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Nombre</th>
                                <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Tipo de material</th>
                                <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Temperatura</th>
                                <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Toxicidad</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-500  divide-y divide-gray-200">
                        @foreach($materials as $material)     
                            <tr class="text-center">
                                <td class="py-3">{{$material->name}}</td>
                                <td class="py-3">{{$material->type_material}}</td>
                                <td class="py-3">{{$material->temperature}}</td>
                                @if($material->toxic == 1)
                                    <td class="py-3 bg-pink-700 text-white font-bold">Tóxico</td>
                                @else
                                    <td class="py-3 bg-pink-200 font-bold">No tóxico</td>
                                @endif
                            </tr>
                        @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>