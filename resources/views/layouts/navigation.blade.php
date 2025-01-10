<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center w-24">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('storage/uploads/logo/black.png') }}" alt="Logo">
                    </a>
                </div>


                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Download') }}
                    </x-nav-link>

                    <x-nav-link :href="route('subscription')" :active="request()->routeIs('subscription')">
                        {{ __('Subscription') }}
                    </x-nav-link>

                    @if (auth()->user() && auth()->user()->role === 'admin')
                        <x-nav-link :href="route('assets.index')" :active="request()->routeIs('assets.*')">
                            {{ __('Assets') }}

                        </x-nav-link>
                    @endif
                    @if (auth()->user() && auth()->user()->role === 'admin')
                        <x-nav-link :href="route('transaksi')" :active="request()->routeIs('transaksi')">
                            {{ __('Transaksi') }}
                        </x-nav-link>
                    @endif
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-nav-link>

                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6 relative z-50">
                <x-dropdown align="right">
                    <!-- Trigger -->
                    <x-slot name="trigger">
                        <img
                        src="{{ Auth::user()->profile_photo_url }}"
                        alt="Avatar"
                        class="rounded-full w-12 h-12" />
                    </x-slot>

                    <!-- Dropdown Content -->
                    <x-slot name="content">
                        <div class="">
                            <!-- User Info -->
                            <div class="px-4 py-3 flex items-center border-b">
                                <!-- Avatar -->
                                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://via.placeholder.com/60' }}"
                                    alt="Avatar" class="rounded-full w-12 h-12">
                                <div class="ml-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Download') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('subscription')">
                                {{ __('Subscription') }}
                            </x-dropdown-link>
                            @if (auth()->user() && auth()->user()->role === 'admin')
                                <x-dropdown-link :href="route('assets.index')">
                                    {{ __('Assets') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('transaksi')">
                                    {{ __('Transaksi') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Divider -->
                            <div class="border-t border-gray-200 my-2"></div>

                            <!-- Log Out -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>





            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
