<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

            <x-message-status-success class="mb-4" :status="session('status')" :background="session('background')" :textcolor="session('textcolor')" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-2 border-gray-400">
                    
                <table class="overflow-x-auto overflow-y-auto w-full bg-white divide-y divide-gray-200">
                    <thead class="bg-blue-200">
                        <tr class="divide-x">
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">ID</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Nombre</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Email</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Contraseña</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-700 font-bold uppercase">Rol</th>
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
                                <td class="py-3">{{$user->id}}</td>
                                <td class="py-3">{{$user->name}}</td>
                                <td class="py-3">{{$user->email}}</td>
                                <td class="py-3">{{$user->password}}</td>
                                <td class="py-3">{{$user->type}}</td>
                                <td class="py-3">{{$user->nick}}</td>
                                <td class="py-3">{{$user->img}}</td>
                                <td class="py-3">{{$user->create_at}}</td>
                                <td class="py-3">
                                <div class="flex justify-center space-x-1">
                                    <button class="border-2 border-indigo-200 rounded-md p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    </button>
                                    <x-nav-link  :href="route('destroy', ['id'=> $user->id])" class="font-bold" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </x-nav-link>
                                </div>
                                </td>
                            </tr>
                        @endforeach 
                    @else    
                        <tr class="text-center">
                            <td colspan="9" class="py-3 font-bold text-red-600 text-lg">Se ha producido un error al listar a los usuarios</td>
                        </tr>

                    @endif    
                       
                    </tbody>
                    {{$users->links()}}
                </table> 
            </div>
        </div>
    </div>
</x-app-layout>
