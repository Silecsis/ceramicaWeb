<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usuarios -> Editar usuario de nombre '<b class="text-blue-600">{{$user->name}}</b>'
        </h2>
    </x-slot>

    <div>
        <x-guest-layout>
            <x-auth-card-sinLogo>
                <!-- Información operación -->
                <x-message-status-success class="mb-4" :status="session('status')" />
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('update.admin',['id'=>$user->id]) }}" enctype="multipart/form-data" >
                    @csrf

                    <!-- Name -->
                    <div >
                        <x-label for="name" :value="__('Nombre')" class="font-bold"/>
                        
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required/>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" class="font-bold"/>

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required />
                    </div>

                     <!-- Type -->
                     <div class="mt-4">
                        <x-label for="type" :value="__('Tipo de usuario')" class="font-bold"/>
                         <select name="type"  class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                             <option value="admin" @if($user->type=="admin") selected @endif)>Administrador</option>
                             <option value="user" @if($user->type=="user") selected @endif)>Socio</option>
                         </select>
                    </div>

                    <!-- Nick -->
                    <div class="mt-4">
                        <x-label for="nick" :value="__('Nick')" class="font-bold"/>

                        <x-input id="nick" class="block mt-1 w-full" type="text" name="nick" :value="$user->nick" required />
                    </div>

                    <!-- Imagen Actual-->
                    <div class="mt-4">
                        <x-label for="imgAct" :value="__('Imagen actual: ')" class="font-bold"/>

                        <div id="imgAct">{{$user->img}}</div>
                    </div>

                    <!-- Imagen Nueva-->
                    <div class="mt-4">
                        <x-label for="image" :value="__('Cargar imagen nueva: ')" class="font-bold"/>
                        <input id="image" class="block mt-1 w-full" type="file" name="image" required />

                           <div class="flex flex-wrap justify-center mt-2">
                              <div class="w-6/12 sm:w-4/12 px-4">
                             <!--Para imprimir imagen en el proyecto--> 
                                 <img src="{{ route('user.avatar', ['filename'=>Auth::user()->img])}}" alt="Imagen de perfil" class="shadow rounded max-w-full h-auto align-middle border-none" />
                              </div>
                           </div>
                    </div>
                     <!-- Boton-->
                     <div class="mt-4">
                         <a href="{{ route('users') }}"  
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150
                                    ml-4 flex float-left text-white font-bold bg-blue-400 p-4 rounded p-1.5">
                                Volver a "Usuarios"
                        </a>

                        <x-button class="ml-4 flex float-right text-white font-bold bg-indigo-500 p-4 rounded p-1.5">
                             {{ __('Editar') }}
                         </x-button>
                    </div>
                   
                </form>
            </x-auth-card-sinLogo>
        </x-guest-layout>
    </div>
</x-app-layout>