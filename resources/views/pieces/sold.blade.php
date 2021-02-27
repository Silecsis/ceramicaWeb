<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis piezas-> ¡Vendida!') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

        <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis piezas') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

            <x-message-status-success class="mb-4" :status="session('status')" />

            <x-auth-card-sinLogo>
                <!-- Información operación -->
                <x-message-status-success class="mb-4" :status="session('status')" />
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('update.profile',['id'=>$user->id]) }}" enctype="multipart/form-data" >
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

                    <!-- Password -->
                    <div class="mt-4">
                         <x-label for="password" class="font-bold" :value="__('Contraseña: ')" />
            
                         <x-input id="password" class="block mt-1 w-full"
                                         type="password"
                                         name="password"/>
                     </div>
            
                     <!-- Confirm Password -->
                     <div class="mt-4">
                         <x-label for="password_confirmation" class="font-bold" :value="__('Confirmación de la contraseña: ')" />
            
                         <x-input id="password_confirmation" class="block mt-1 w-full"
                                         type="password"
                                         name="password_confirmation"/>
                     </div>

                    <!-- Nick -->
                    <div class="mt-4">
                        <x-label for="nick" :value="__('Nick')" class="font-bold"/>

                        <x-input id="nick" class="block mt-1 w-full" type="text" name="nick" :value="$user->nick" required />
                    </div>

                    <x-input id="type" hidden type="text" name="type" :value="$user->type"/>

                    <!-- Imagen Actual-->
                    <div class="mt-4">
                        <x-label for="imgAct" :value="__('Imagen actual: ')" class="font-bold"/>

                        <div class="flex flex-wrap justify-center mt-2">
                              <div class="w-6/12 sm:w-4/12 px-4">
                             <!--Para imprimir imagen en el proyecto--> 
                                 <img src="{{ route('user.avatar', ['filename'=>Auth::user()->img])}}" alt="Imagen de perfil" class="shadow rounded max-w-full h-auto align-middle border-none" />
                              </div>
                           </div>
                    </div>

                    <!-- Imagen Nueva-->
                    <div class="mt-4">
                        <x-label for="image" :value="__('Cargar imagen nueva: ')" class="font-bold"/>
                        <input id="image" class="block mt-1 w-full" type="file" name="image"/>

                           
                    </div>
                     <!-- Boton-->
                     <div class="mt-4">
                        <x-button class="ml-4 flex float-right text-white font-bold bg-indigo-500 p-4 rounded p-1.5">
                             {{ __('Confirmar venta') }}
                         </x-button>
                    </div>
                   
                </form>
            </x-auth-card-sinLogo> 
        </div>
    </div>
</x-app-layout>
        </div>
    </div>
</x-app-layout>