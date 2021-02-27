<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios -> Ventas de cada usuario') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

            <x-message-status-success class="mb-4" :status="session('status')" />

            <nav class="navbar navbar-light py-6 mb-4"> 
               <div class="bg-white py-4 px-2 rounded border-2 border-gray-300">
                    <div class="flex bg-blue-400 rounded pt-4">
                        <h4 class="pb-4  m-auto text-white font-bold text-lg">Cuadro de búsqueda</h4>
                    </div>
                    <form class="form-inline pt-4" method="GET" action="{{ route('sales',['pagination'=>4])}}" >

                        <!--Lista todos los usuarios:-->
                            <select name="buscaUser"  class="form-control  mr-sm-2 rounded bg-gray-200">
                                <option value="" >Buscar por usuario</option>
                                @foreach ($usersAll as $user)
                                    <option value="{{$user->id}}">{{$user->email}}</option>
                                @endforeach    
                            </select>

                        <!--Lista todas piezas:-->
                            <select name="buscaPiece"  class="form-control ml-2 mr-sm-2 rounded bg-gray-200">
                                <option value="" >Buscar por pieza</option>
                                @foreach ($piecesAll as $piece)
                                    <option value="{{$piece->id}}">{{$piece->name}}</option>
                                @endforeach    
                            </select>

                        <input name="buscaNombre" class="form-control ml-2 mr-sm-2 rounded bg-gray-200 w-40" type="search" placeholder="Por venta" aria-label="Search">
                        <input name="buscaPrecio" class="form-control  ml-2 mr-sm-2 rounded bg-gray-200 w-40" type="search" placeholder="Por precio " aria-label="Search">
                        <input name="buscaFechaLogin" class="form-control ml-2 mr-sm-2 rounded bg-gray-200" type="date" placeholder="Por fecha de creación" aria-label="Search">

                        <button class="btn btn-outline-success bg-blue-200 border-2 text-gray-500 font-bold border-gray-400 rounded p-2 float-right" type="submit">Buscar</button>
                    </form>
               </div>  
            </nav>

            <!--SELECCION DE PAGINACION-->  
            <div class="hidden sm:flex mt-8 mb-1  ">
                 <x-dropdown width="48">
                     <x-slot name="trigger"  >
                         <button class="flex items-center bg-white mr-sm-2 px-6 rounded text-gray-600 font-bold border-2 border-gray-400">
                             Ventas x página
                             <div class="ml-1">
                                 <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                 </svg>
                             </div>
                         </button>
                     </x-slot>
                     <x-slot name="content">
                         <form method="GET">
                             <x-dropdown-link :href="route('sales',['pagination'=>4])">{{ __('Paginación de 4') }}</x-dropdown-link>
                             <x-dropdown-link :href="route('sales',['pagination'=>6])">{{ __('Paginación de 6') }}</x-dropdown-link>
                             <x-dropdown-link :href="route('sales',['pagination'=>8])">{{ __('Paginación de 8') }}</x-dropdown-link>
                             <x-dropdown-link :href="route('sales',['pagination'=>10])">{{ __('Paginación de 10') }}</x-dropdown-link>
                         </form>
                     </x-slot>
                 </x-dropdown>
            </div>

            <!--TABLA-->  
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-2 border-gray-400 p-4">
                <table class="overflow-x-auto overflow-y-auto w-full bg-white divide-y divide-gray-200 mt-4">
                    <thead class="bg-blue-300">
                        <tr class="divide-x">
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Email de usuario</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Nombre de venta</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Nombre de pieza</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Precio de la venta</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Fecha creación</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-xs divide-y divide-gray-200">
                    @if($success)
                        @foreach($sales as $sale)     
                            <tr class="text-center">
                                <!--Buscamos el email de usuario-->
                                @foreach($usersSales as $user)
                                    @if($sale->user_id == $user['id'])
                                        <td class="py-3">{{$user['email']}}</td>
                                    @endif
                                @endforeach 
                                <td class="py-3">{{$sale->name}}</td>
                                <!--Buscamos el nombre de la pieza-->
                                @foreach($piecesSales as $piece)
                                    @if($sale->piece_id == $piece['id'])
                                        <td class="py-3">{{$piece['name']}}</td>
                                    @endif
                                @endforeach
                                <td class="py-3">{{$sale->price}} €</td>
                                <td class="py-3">{{substr($sale->created_at,0,10)}}</td>
                            </tr>
                        @endforeach 
                    @else    
                        <tr class="text-center">
                            <td colspan="5" class="py-3 font-bold text-red-600 text-lg">{{ $message }}</td>
                        </tr>

                    @endif    
                       
                    </tbody>
                    {{$sales->appends(request()->all())->links()}}
                </table> 
            </div>
        </div>
    </div>
</x-app-layout>