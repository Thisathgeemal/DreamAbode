<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-white font-bold">Messages</h2>
                <p class="text-sm text-gray-300 mt-1">View and manage your conversations with others.</p>
            </div>

            <a href="{{ request()->headers->get('referer') ?? route('sales') }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-[#5CFFAB] text-black rounded-xl font-medium shadow-md 
                hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-arrow-left inline sm:hidden"></i>
                <span class="hidden sm:inline">Back</span>
            </a>
        </div>
    </div>

    <!-- Chat List -->
    <livewire:chat :userId="$userId ?? null" />

</x-app-layout>
