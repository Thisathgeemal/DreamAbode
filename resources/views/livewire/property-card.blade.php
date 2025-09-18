<div>
    <!-- Filters -->
    <div class="flex justify-center md:mt-12 px-4">
        <div x-data="{ showMore: false }" wire:ignore.self class="p-4 bg-[#5CFFAB] rounded-2xl shadow-md w-full max-w-6xl">

            <!-- Main Filters Row + More Button -->
            <div class="flex flex-col sm:flex-row sm:flex-wrap justify-center items-center gap-4">

                <!-- Property Name Input -->
                <div class="relative w-full sm:w-80">
                    <img src="/images/rental.png" alt="Property Name"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-8 h-8">
                    <input type="text" wire:model.live="search" placeholder="Property Name"
                        class="border-2 border-white bg-white/20 text-black p-2 pl-11 rounded focus:ring-2 focus:ring-white focus:outline-none w-full">
                </div>

                <!-- Property Type Select -->
                <div class="relative w-full sm:w-80">
                    <img src="/images/houses.png" alt="Property Type"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5">
                    <select wire:model.live="propertyType"
                        class="border-2 border-white bg-white/20 text-black p-2 pl-10 rounded focus:ring-2 focus:ring-white focus:outline-none w-full">
                        <option value="">All Types</option>
                        <option value="house">House</option>
                        <option value="apartment">Apartment</option>
                        <option value="land">Land</option>
                        <option value="bungalow">Bungalow</option>
                        <option value="villa">Villa</option>
                        <option value="commercial">Commercial</option>
                    </select>
                </div>

                <!-- Location Input -->
                <div class="relative w-full sm:w-80">
                    <img src="/images/location.png" alt="Location"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-6">
                    <input type="text" wire:model.live="location" placeholder="Location"
                        class="border-2 border-white bg-white/20 text-black p-2 pl-10 rounded focus:ring-2 focus:ring-white focus:outline-none w-full">
                </div>

                <!-- More Button -->
                <div class="flex justify-center sm:justify-start w-full sm:w-auto">
                    <button @click="showMore = !showMore"
                        class="flex items-center justify-center w-12 h-12 bg-white rounded-lg hover:bg-gray-200 transition">
                        <img :src="showMore ? '/images/up-arrow.png' : '/images/down-arrow.png'" alt="Toggle Filters"
                            class="w-7 h-7">
                    </button>
                </div>
            </div>

            <!-- Additional Filters Row -->
            <div x-show="showMore" x-transition x-cloak
                class="flex flex-col sm:flex-row sm:flex-wrap justify-start items-center gap-4 mt-4 md:pl-8">

                <!-- Max Price -->
                <div class="relative w-full sm:w-80">
                    <img src="/images/price.png" alt="Max Price"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-7 h-8">
                    <input type="number" wire:model.live="maxPrice" placeholder="Max Price"
                        class="border-2 border-white bg-white/20 text-black p-2 pl-11 rounded focus:ring-2 focus:ring-white focus:outline-none w-full">
                </div>

                <!-- Min Bedrooms -->
                <div class="relative w-full sm:w-80">
                    <img src="/images/bedrooms.png" alt="Min Bedrooms"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5">
                    <input type="number" wire:model.live="minBedrooms" placeholder="Min Bedrooms"
                        class="border-2 border-white bg-white/20 text-black p-2 pl-10 rounded focus:ring-2 focus:ring-white focus:outline-none w-full">
                </div>

                <!-- Min Bathrooms -->
                <div class="relative w-full sm:w-80">
                    <img src="/images/bathrooms.png" alt="Min Bathrooms"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6">
                    <input type="number" wire:model.live="minBathrooms" placeholder="Min Bathrooms"
                        class="border-2 border-white bg-white/20 text-black p-2 pl-10 rounded focus:ring-2 focus:ring-white focus:outline-none w-full">
                </div>

                <!-- Clear Filters Button -->
                <div class="flex justify-center sm:justify-start w-full sm:w-auto">
                    <button wire:click="resetFilters"
                        class="flex items-center justify-center w-12 h-12 bg-white rounded-lg hover:bg-gray-200 transition">
                        <img src="/images/clear.png" alt="Clear Filters" class="w-7 h-7">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties Grid -->
    <div class="flex flex-wrap gap-10 justify-center p-4 mt-8">
        @forelse($properties as $prop)
            <div
                class="bg-white rounded-2xl shadow-lg overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer">

                <!-- Image Section -->
                <div class="relative">
                    @if ($prop->images->count() > 0)
                        <img src="{{ asset('storage/' . $prop->images[0]->image_path) }}" alt="Property Image"
                            class="w-full h-60 object-cover">
                    @else
                        <div class="w-full h-60 bg-gray-200 flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif

                    <!-- Favourite Button -->
                    <div class="absolute top-2 right-2 bg-white rounded-lg p-2 shadow hover:bg-gray-200 transition">
                        <span class="text-sm font-bold text-gray-800">{{ ucfirst($prop->post_type) }}</span>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="p-4 bg-[#5CFFAB] text-black text-center">
                    <h2 class="text-xl font-bold m-1 truncate">{{ $prop->property_name }}</h2>

                    <div class="flex justify-center items-center space-x-2 mt-3 mb-5">
                        <img src="/images/Location.png" alt="Location" class="h-7 w-5.5">
                        <span class="truncate">{{ $prop->location }}</span>
                    </div>

                    <div class="flex justify-center items-center gap-8 mt-2">
                        <div class="flex items-center space-x-1">
                            <img src="/images/money.png" alt="Price" class="h-6 w-6">
                            <span class="text-sm font-semibold pl-1 text-gray-800">RS {{ $prop->formatted_price }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <img src="/images/houses.png" alt="PropertyType" class="h-5 w-5">
                            <span
                                class="text-sm font-semibold pl-2 text-gray-800">{{ ucfirst($prop->property_type) }}</span>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-center">
                        <a href="/member/property/viewAd/{{ $prop->property_id }}"
                            class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-[100px] hover:scale-105 hover:bg-gray-200 text-center inline-block">
                            Explore
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-green-500 text-center text-lg">No properties available.</p>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-6 mx-120">
        {{ $properties->links('vendor.livewire.tailwind') }}
    </div>
</div>
