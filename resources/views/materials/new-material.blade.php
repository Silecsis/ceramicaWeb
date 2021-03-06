<!--Vista de nuevo material.
    Muestra un form para rellenar los campos del nuvo material..
-->
<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Materiales -> Nuevo material
        </h2>
    </x-slot>

    <div >
        <x-guest-layout>
            <x-auth-card-sinLogo>
                <!-- Información operación -->
                <x-message-status-success class="mb-4" :status="session('status')" />
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('create.material') }}" enctype="multipart/form-data" >
                    @csrf

                    <!-- Name -->
                    <div >
                        <x-label for="name" :value="__('Nombre')" class="font-bold"/>
                        
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required/>
                    </div>

                    <!-- Tipo de material -->
                    <div class="mt-4">
                        <x-label for="type_material" :value="__('Tipo de material')" class="font-bold"/>

                        <x-input id="tipo_de_material" class="block mt-1 w-full" type="text" name="type_material" :value="old('type')" required />
                    </div>

                     <!-- Temperature -->
                     <div class="mt-4">
                        <!--No es una errata, se escribe cocción. Es una propiedad en los materiales de ceramica--> 
                        <x-label for="temperatura" :value="__('Temperatura de cocción')" class="font-bold"/>

                        <x-input id="temperatura" class="block mt-1 w-full" type="number" name="temperature" :value="old('temperature')" required />
                    </div>


                     <!-- Toxic -->
                     <div class="mt-4">
                        <x-label for="toxico" :value="__('¿Tóxico?')" class="font-bold"/>
                         <select name="toxic" id="toxico" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                             <option value="0" @if(old('toxic')=='0') selected @endif >No</option>
                             <option value="1" @if(old('toxic')=='1') selected @endif>Si</option>
                         </select>
                    </div>

            
                     <!-- Boton-->
                     <div class="mt-4">
                        <x-button class="flex float-right text-white font-bold bg-indigo-500 p-4 rounded p-1.5">
                             {{ __('Crear nuevo material') }}
                         </x-button>

                         <a href="{{ route('materials',['pagination'=>4]) }}"  
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150
                                    flex float-right text-white font-bold bg-blue-400 p-4 rounded p-1.5">
                                Volver a "Materiales"
                        </a>
                    </div>
                </form>
            </x-auth-card-sinLogo>
        </x-guest-layout>
    </div>
</x-app-layout>