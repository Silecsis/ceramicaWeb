<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
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
                    <form class="form-inline pt-4" method="GET" action="{{ route('users',['pagination'=>4])}}" >

                        <input name="buscaNombre" class="form-control mr-sm-2 rounded bg-gray-200 w-40" type="search" placeholder="Por nombre" aria-label="Search">
                        <input name="buscaEmail" class="form-control ml-2 mr-sm-2 rounded bg-gray-200" type="search" placeholder="Por email" aria-label="Search">
                        <input name="buscaNick" class="form-control  ml-2 mr-sm-2 rounded bg-gray-200 w-40" type="search" placeholder="Por nick" aria-label="Search">
                        <input name="buscaFechaLogin" class="form-control ml-2 mr-sm-2 rounded bg-gray-200" type="date" placeholder="Por fecha de creación" aria-label="Search">

                        <label for="tipo" class="ml-4">Tipo de usuario:</label>
                            <select name="buscaTipo"  class="form-control  mr-sm-2 rounded bg-gray-200">
                                <option value="0" >Todos</option>
                                <option value="admin">Administrador</option>
                                <option value="user">Socio</option>
                            </select>
                        <button class="btn btn-outline-success bg-blue-200 border-2 text-gray-500 font-bold border-gray-400 rounded p-2 float-right" type="submit">Buscar</button>
                    </form>
               </div>  
            </nav>

            
            <a href="{{ route('new.user') }}"  class="text-lg text-gray-600 font-bold bg-yellow-300 border-4 border-gray-400 p-4 rounded p-1.5">Nuevo usuario</a>
            <a   class="text-lg text-white font-bold bg-indigo-500 ml-4 p-4 rounded p-1.5">Piezas de cada usuario</a>
            <a href="{{route('sales',['pagination'=>4])}}" class="text-lg text-white font-bold bg-indigo-500 ml-4 p-4 rounded p-1.5">Ventas de cada usuario</a>

            <!--SELECCION DE PAGINACION-->  
            <div class="hidden sm:flex mt-8 mb-1  ">
                 <x-dropdown width="48">
                     <x-slot name="trigger"  >
                         <button class="flex items-center bg-white mr-sm-2 px-6 rounded text-gray-600 font-bold border-2 border-gray-400">
                             Usarios x página
                             <div class="ml-1">
                                 <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                 </svg>
                             </div>
                         </button>
                     </x-slot>
                     <x-slot name="content">
                         <form method="GET">
                             <x-dropdown-link :href="route('users',['pagination'=>4])">{{ __('Paginación de 4') }}</x-dropdown-link>
                             <x-dropdown-link :href="route('users',['pagination'=>6])">{{ __('Paginación de 6') }}</x-dropdown-link>
                             <x-dropdown-link :href="route('users',['pagination'=>8])">{{ __('Paginación de 8') }}</x-dropdown-link>
                             <x-dropdown-link :href="route('users',['pagination'=>10])">{{ __('Paginación de 10') }}</x-dropdown-link>
                         </form>
                     </x-slot>
                 </x-dropdown>
            </div>

            <!--TABLA-->  
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-2 border-gray-400 p-4">
                <table class="overflow-x-auto overflow-y-auto w-full bg-white divide-y divide-gray-200 mt-4">
                    <thead class="bg-blue-300">
                        <tr class="divide-x">
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Nombre</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Email</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Tipo</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Nick</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Imagen</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Fecha creación</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-xs divide-y divide-gray-200">
                    @if($success)
                        @foreach($users as $user)     
                            <tr class="text-center">
                                <td class="py-3">{{$user->name}}</td>
                                <td class="py-3">{{$user->email}}</td>
                                <td class="py-3">{{$user->type}}</td>
                                <td class="py-3">{{$user->nick}}</td>
                                <td class="py-3 flex justify-center"> 
                                @if(is_null($user->img))
                                    <img alt="imagen defecto" width="48" height="48" class="ml-1 rounded-full w-10 h-10 mr-4 shadow-lg" src="{{ route('user.avatar', 'default-img.png')}}"
                                @else 
                                    <img alt="imagen user" width="48" height="48" class="ml-1 rounded-full w-10 h-10 mr-4 shadow-lg" src="{{ route('user.avatar', ['filename'=> $user->img])}}">
                                @endif
                                </td>
                                <td class="py-3">{{substr($user->created_at,0,10)}}</td>
                                <td class="py-3">
                                <div class="flex justify-center space-x-1">
                                    
                                    @if($user->id != Auth::user()->id)
                                        <x-nav-link  :href="route('edit.admin', ['id'=> $user->id])" class="font-bold" >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </x-nav-link>

                                        <x-nav-link  :href="route('destroy.admin', ['id'=> $user->id])" class="font-bold" >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-red-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </x-nav-link>
                                    @endif
                                </div>
                                </td>
                            </tr>
                        @endforeach 
                    @else    
                        <tr class="text-center">
                            <td colspan="7" class="py-3 font-bold text-red-600 text-lg">{{ $message }}</td>
                        </tr>

                    @endif    
                       
                    </tbody>
                    {{$users->appends(request()->all())->links()}}
                </table> 
            </div>
        </div>
    </div>
</x-app-layout>
