<!--Vista de listado de valor del euro por paises.
    Muestra una lista con todos los valores.
-->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Valor del euro') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <!--TABLA-->  
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-2 border-gray-400 p-4">
                <div class="flex bg-blue-400 rounded pt-4">
                    <h4 class="pb-4  m-auto text-white font-bold text-lg">Fecha de actualización del valor del euro: 
                    <span class="text-yellow-200">{{$fecha}}</span></h4>
                </div>
                <table class="overflow-x-auto overflow-y-auto w-full bg-white divide-y divide-gray-200 mt-4">
                    <thead class="bg-blue-300">
                        <tr class="divide-x">
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Código del país</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Valor del euro</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-xs divide-y divide-gray-200">  
                        @foreach($rates as $key=>$value)
                        <tr class="text-center">
                            <td class="py-3">{{$key}}</td>
                            <td class="py-3">{{$value}}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</x-app-layout>