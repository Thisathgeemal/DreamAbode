<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>

    {{-- Header --}}
    <header x-data="{ open: false }" class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                {{-- logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-mark class="h-[95px] w-auto" />
                    </a>
                </div>

                {{-- Navigation Links --}}
                <div class="hidden sm:flex space-x-8">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
                    <x-nav-link href="{{ route('sales') }}" :active="request()->routeIs('sales')">Sales</x-nav-link>
                    <x-nav-link href="{{ route('rentals') }}" :active="request()->routeIs('rentals')">Rentals</x-nav-link>
                    <x-nav-link href="{{ route('projects') }}" :active="request()->routeIs('projects')">Projects</x-nav-link>
                    <x-nav-link href="{{ route('loans') }}" :active="request()->routeIs('loans')">Loans</x-nav-link>
                    <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-nav-link>
                </div>

                {{-- Login & Register Buttons --}}
                <div class="hidden sm:flex flex-shrink-0">
                    <a href="{{ route('login') }}">
                        <button
                            class="text-sm font-semibold border border-[#5CFFAB] text-green-600 px-5 py-2 rounded hover:bg-[#5CFFAB] hover:text-black transition">
                            Sign in
                        </button>
                    </a>
                    <a href="{{ route('register') }}">
                        <button
                            class="text-sm font-semibold bg-[#5CFFAB] text-black px-5 py-2 rounded hover:bg-[#4de79a] transition ml-2">
                            Sign up
                        </button>
                    </a>
                </div>

                <!-- Hamburger for mobile -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition
            class="sm:hidden bg-white rounded-lg shadow-lg p-4 transition-all duration-300">
            <ul class="flex flex-col items-center space-y-2">
                <li>
                    <a href="{{ route('home') }}"
                        class="inline-block text-center font-medium px-5 py-2 rounded transition
               {{ request()->routeIs('home') ? 'bg-[#5CFFAB] text-black' : 'text-gray-700 hover:bg-[#4de79a] hover:text-black' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales') }}"
                        class="inline-block text-center font-medium px-5 py-2 rounded transition
               {{ request()->routeIs('sales') ? 'bg-[#5CFFAB] text-black' : 'text-gray-700 hover:bg-[#4de79a] hover:text-black' }}">
                        Sales
                    </a>
                </li>
                <li>
                    <a href="{{ route('rentals') }}"
                        class="inline-block text-center font-medium px-5 py-2 rounded transition
               {{ request()->routeIs('rentals') ? 'bg-[#5CFFAB] text-black' : 'text-gray-700 hover:bg-[#4de79a] hover:text-black' }}">
                        Rentals
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects') }}"
                        class="inline-block text-center font-medium px-5 py-2 rounded transition
               {{ request()->routeIs('projects') ? 'bg-[#5CFFAB] text-black' : 'text-gray-700 hover:bg-[#4de79a] hover:text-black' }}">
                        Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('loans') }}"
                        class="inline-block text-center font-medium px-5 py-2 rounded transition
               {{ request()->routeIs('loans') ? 'bg-[#5CFFAB] text-black' : 'text-gray-700 hover:bg-[#4de79a] hover:text-black' }}">
                        Loans
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="inline-block text-center font-medium px-5 py-2 rounded transition
               {{ request()->routeIs('about') ? 'bg-[#5CFFAB] text-black' : 'text-gray-700 hover:bg-[#4de79a] hover:text-black' }}">
                        About
                    </a>
                </li>
                <li class="flex justify-center space-x-2 pt-2">
                    <a href="{{ route('login') }}">
                        <button
                            class="text-sm font-semibold border border-[#5CFFAB] text-green-600 px-5 py-2 rounded hover:bg-[#4de79a] hover:text-black transition">
                            Sign in
                        </button>
                    </a>
                    <a href="{{ route('register') }}">
                        <button
                            class="text-sm font-semibold bg-[#5CFFAB] text-black px-5 py-2 rounded hover:bg-[#4de79a] transition">
                            Sign up
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    <footer class="w-full bg-white py-8 mt-8">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 text-center">

            <!-- Footer Navigation -->
            <nav class="mb-4">
                <ul class="flex flex-wrap justify-center gap-x-2 gap-y-2 text-base sm:text-md text-gray-700">
                    <li class="after:content-['|'] after:ml-1 last:after:content-none">
                        <a href="./" class="hover:text-green-600 transition">Home</a>
                    </li>
                    <li class="after:content-['|'] after:ml-1 last:after:content-none">
                        <a href="./sales" class="hover:text-green-600 transition">Sales</a>
                    </li>
                    <li class="after:content-['|'] after:ml-1 last:after:content-none">
                        <a href="./rentals" class="hover:text-green-600 transition">Rentals</a>
                    </li>
                    <li class="after:content-['|'] after:ml-1 last:after:content-none">
                        <a href="./projects" class="hover:text-green-600 transition">Projects</a>
                    </li>
                    <li class="after:content-['|'] after:ml-1 last:after:content-none">
                        <a href="./loans" class="hover:text-green-600 transition">Loans</a>
                    </li>
                    <li>
                        <a href="./about" class="hover:text-green-600 transition">About</a>
                    </li>
                </ul>
            </nav>

            <!-- Social Media Icons -->
            <div class="flex flex-wrap justify-center gap-5 mb-4">
                <a href="#" aria-label="Twitter"
                    class="w-10 h-10 border border-gray-400 rounded-full flex items-center justify-center hover:bg-[#a3ffd1] transition">
                    <img src="/images/Twitter.png" alt="Twitter" class="w-6 h-6 object-contain">
                </a>
                <a href="#" aria-label="Instagram"
                    class="w-10 h-10 border border-gray-400 rounded-full flex items-center justify-center hover:bg-[#a3ffd1] transition">
                    <img src="/images/Instagram.png" alt="Instagram" class="w-6 h-6 object-contain">
                </a>
                <a href="#" aria-label="LinkedIn"
                    class="w-10 h-10 border border-gray-400 rounded-full flex items-center justify-center hover:bg-[#a3ffd1] transition">
                    <img src="/images/LinkedIn.png" alt="LinkedIn" class="w-6 h-6 object-contain">
                </a>
                <a href="#" aria-label="Facebook"
                    class="w-10 h-10 border border-gray-400 rounded-full flex items-center justify-center hover:bg-[#a3ffd1] transition">
                    <img src="/images/Facebook.png" alt="Facebook" class="w-6 h-6 object-contain">
                </a>
                <a href="#" aria-label="Skype"
                    class="w-10 h-10 border border-gray-400 rounded-full flex items-center justify-center hover:bg-[#a3ffd1] transition">
                    <img src="/images/Skype.png" alt="Skype" class="w-6 h-6 object-contain">
                </a>
            </div>

            <!-- Copyright -->
            <p class="text-sm sm:text-base text-gray-600">
                © {{ date('Y') }} Dream Abode. All Rights Reserved.
            </p>
        </div>
    </footer>

    @livewireScripts
</body>

</html>
