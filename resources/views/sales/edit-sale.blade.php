<!--Vista de edición de venta.
    Muestra los datos de la venta para su edición.
    Solo se modifica el nombre y el precio.-->
<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis ventas -> Editar venta  de nombre '<b class="text-blue-600">{{$sale->name}}</b>'
        </h2>
    </x-slot>

    <div >
        <x-guest-layout>
            <x-auth-card-sinLogo>
                <!-- Información operación -->
                <x-message-status-success class="mb-4" :status="session('status')" />
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('update.sale',['id'=>$sale->id]) }}">
                    @csrf

                    <!-- Price -->
                    <div class="mt-4">
                        <x-label for="price" :value="__('Precio de venta')" class="font-bold"/>

                        <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="$sale->price" required />
                    </div>
                    
                    <!-- Name -->
                    <div >
                        <x-label for="name" :value="__('Nombre de venta')" class="font-bold"/>
                        
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$sale->name" required/>
                    </div>


                     

                     <!-- Boton-->
                     <div class="mt-4">
                         <a href="{{ route('my.sales',['pagination'=>4]) }}"  
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150
                                    ml-4 flex float-left text-white font-bold bg-blue-400 p-4 rounded p-1.5">
                                Volver a "Mis ventas"
                        </a>

                        <x-button class="ml-4 flex float-right text-white font-bold bg-indigo-500 p-4 rounded p-1.5">
                             {{ __('Editar venta') }}
                         </x-button>
                    </div>
                   
                </form>
            </x-auth-card-sinLogo>
        </x-guest-layout>
    </div>
</x-app-layout>