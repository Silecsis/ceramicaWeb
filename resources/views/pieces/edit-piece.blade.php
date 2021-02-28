<!--Vista de edición de pieza.
    Muestra los datos de la pieza para su edición-->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis piezas-> Editar pieza de nombre "<b class="text-blue-600">{{$piece->name}}</b>"
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

            <x-message-status-success class="mb-4" :status="session('status')" />

            <x-auth-card>
                <x-slot name="logo">

                    <div class="flex justify-center space-x-1 ">
                        <div class="bg-white rounded p-4">
                            <img alt="imagen pieza"  class="ml-1 rounded  h-80 mr-4 shadow-lg" src="{{ route('image.file', ['filename'=>$piece->img])}}">
                         </div>
                     </div>
                </x-slot>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('update.piece',['id'=>$piece->id]) }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div >
                        <x-label for="name" :value="__('Nombre')" class="font-bold"/>
                        
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$piece->name" required/>
                    </div>

                    <!-- Description -->
                    <div div class="mt-4">
                        <x-label for="description" :value="__('Descripción')" class="font-bold"/>
                        
                        <x-input id="description" class="block mt-1 w-full" type="text" name="description" :value="$piece->description" required/>
                    </div>

                    <!-- Imagen Nueva-->
                    <div class="mt-4">
                        <x-label for="image" :value="__('Cargar imagen nueva: ')" class="font-bold"/>
                        <input id="image" class="block mt-1 w-full" type="file" name="image"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('my.pieces',['pagination'=>4]) }}"  
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150
                                    ml-4 flex float-left text-white font-bold bg-blue-400 p-4 rounded p-1.5">
                                    Volver a "Mis piezas"
                        </a>

                        <x-button class="ml-4 flex float-right text-white font-bold bg-indigo-500 p-4 rounded p-1.5">
                            {{ __('Editar pieza') }}
                        </x-button>
                    </div>
                </form>
            </x-auth-card> 
        </div>
    </div>
</x-app-layout>