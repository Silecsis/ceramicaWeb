<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo-small class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <!--HOME-->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold">
                        {{ __('Home') }}
                    </x-nav-link>

                    <!--SOLO SI ES ADMIN-->
                    @if (Auth::user()->type == 'admin')
                        <!--Usuarios-->
                        <x-nav-link  :href="route('users',['pagination'=>4])" :active="request()->routeIs('users')" class="font-bold" >
                            {{ __('Usuarios') }}
                        </x-nav-link>
                    @endif

                    <!--Materiales-->
                    <x-nav-link :href="route('materials',['pagination'=>4])" :active="request()->routeIs('materials')" class="font-bold">
                        {{ __('Materiales') }}
                    </x-nav-link>

                    <!--Piezas-->
                    <x-nav-link :href="route('my.pieces',['pagination'=>4])" :active="request()->routeIs('my.pieces')" class="font-bold">
                        {{ __('Mis piezas') }}
                    </x-nav-link>

                    <!--Ventas-->
                    <x-nav-link :href="route('my.sales',['pagination'=>4])" :active="request()->routeIs('my.sales')" class="font-bold">
                        {{ __('Mis ventas') }}
                    </x-nav-link>

                    <!--Valor moneda-->
                    <x-nav-link :href="route('api')" :active="request()->routeIs('api')" class="font-bold">
                        {{ __('Valor del Euro') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Edita mi perfil -->
                        <x-dropdown-link :href="route('edit.profile',['id'=> Auth::user()->id])">  
                           {{ __('Editar mi perfil') }}
                        </x-dropdown-link>
                     
                        
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Salir') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                    @if(is_null(Auth::user()->img))
                        <img alt="imagen defecto" width="48" height="48" class="ml-1 rounded-full w-10 h-10 mr-4 shadow-lg" src="{{ route('user.avatar', 'default-img.png')}}"
                    @else 
                        <img alt="imagen user" width="48" height="48" class="ml-1 rounded-full w-10 h-10 mr-4 shadow-lg" src="{{ route('user.avatar', ['filename'=> Auth::user()->img])}}">
                    @endif
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

             <!-- Navigation Links -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <!--SOLO SI ES ADMIN-->
                @if (Auth::user()->type == 'admin')
                    <!--Usuarios-->
                    <x-responsive-nav-link :href="route('users',['pagination'=>4])" :active="request()->routeIs('users')" class="font-bold" >
                        {{ __('Usuarios') }}
                    </x-responsive-nav-link>
                @endif

            <!--Materiales-->
                <x-responsive-nav-link :href="route('materials',['pagination'=>4])" :active="request()->routeIs('materials')" class="font-bold">
                    {{ __('Materiales') }}
                </x-responsive-nav-link>

                <!--Piezas-->
                <x-responsive-nav-link :href="route('my.pieces',['pagination'=>4])" :active="request()->routeIs('my.pieces')" class="font-bold">
                    {{ __('Mis Piezas') }}
                </x-responsive-nav-link>

                <!--Ventas-->
                <x-responsive-nav-link :href="route('my.sales',['pagination'=>4])" :active="request()->routeIs('my.sales')" class="font-bold">
                    {{ __('Mis Ventas') }}
                </x-responsive-nav-link>

                <!--Valor moneda-->
                <x-nav-link :href="route('api')" :active="request()->routeIs('api')" class="font-bold">
                    {{ __('Valor del Euro') }}
                </x-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Mi perfil -->
                            <!-- Pendiente poner rutas -->
                            <x-dropdown-link :href="route('edit.admin')">  
                                {{ __('Mi perfil') }}
                            </x-dropdown-link>
                        
                            <!-- Configuración -->
                            <x-dropdown-link :href="route('logout')">
                                {{ __('User Configuration') }}
                            </x-dropdown-link>
                            

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Salir') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                        
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
