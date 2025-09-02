<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 transform md:translate-x-0 transition-transform duration-300 ease-in-out z-30 flex flex-col">

        <!-- Logo -->
        <div class="h-20 flex items-center justify-center border-b border-gray-200">
            <x-application-mark class="h-[90px] w-auto" />
        </div>

        <!-- Menu -->
        <ul class="flex-grow space-y-4 px-4 text-sm text-gray-800 font-medium mt-6">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('agent.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('agent.dashboard') ? 'bg-[#5CFFAB] text-black font-semibold' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-house"></i> Dashboard
                </a>
            </li>

            <!-- Property -->
            <li>
                <a href="{{ route('agent.property') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('agent.property') ? 'bg-[#5CFFAB] text-black font-semibold' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-comment-alt"></i> Property
                </a>
            </li>

            <!-- Project -->
            <li>
                <a href="{{ route('agent.project') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('agent.project') ? 'bg-[#5CFFAB] text-black font-semibold' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-comment-alt"></i> Project
                </a>
            </li>

            <!-- Messages -->
            <li>
                <a href="{{ route('agent.messages') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('agent.messages') ? 'bg-[#5CFFAB] text-black font-semibold' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-comment-alt"></i> Messages
                </a>
            </li>

            <!-- Explore Listings -->
            <li>
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('home') ? 'bg-[#5CFFAB] text-black font-semibold' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-globe"></i> Explore Listings
                </a>
            </li>
        </ul>
    </aside>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-25 z-20 md:hidden">
    </div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col md:pl-64">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-gray-200 flex justify-between items-center px-6">
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="md:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6 text-gray-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <span class="text-lg font-semibold">Welcome, {{ Auth::user()->name }}</span>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notification -->
                <button class="relative p-2 rounded-full hover:bg-green-100 focus:outline-none">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9.33-5.032M9 21h6" />
                    </svg>
                    <span
                        class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">3</span>
                </button>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm border-2 border-transparent rounded-full bg-[#5CFFAB] focus:outline-none focus:border-[#4de79a] transition">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_url)
                                <img class="h-9 w-9 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                        <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-dropdown-link
                                href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</x-dropdown-link>
                        @endif
                        <div class="border-t border-gray-200"></div>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-8 overflow-y-auto">
            {{ $slot ?? '' }}
        </main>
    </div>
</div>
