<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Post Your Property Ad</h2>
        <p class="text-sm text-gray-300 mt-1">Easily publish and manage your property listings.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <form id="postAdForm" class="space-y-8" enctype="multipart/form-data">
            @csrf
            <!-- Image Upload Section -->
            <div>
                <label class="block text-lg font-medium text-gray-700 mb-3 text-center">Property Images</label>
                <div id="imagePreviewContainer"
                    class="grid grid-cols-3 gap-4 justify-items-center max-w-3xl mx-auto bg-gray-100 p-6 rounded-xl border border-dashed border-gray-400">
                    <span id="placeholderText" class="col-span-3 text-gray-500 text-sm py-6">Upload up to 6
                        images</span>
                </div>

                <input type="file" id="imageInput" name="images[]" multiple accept="image/*" class="hidden"
                    onchange="handleImageUpload(event)" />

                <div class="flex justify-center mt-4">
                    <button type="button" onclick="document.getElementById('imageInput').click()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-green-500 text-white rounded-xl font-medium shadow-md hover:bg-green-600 transition-all">
                        <i class="fas fa-upload"></i>
                        <span class="hidden sm:inline">Add Images</span>
                    </button>
                </div>
            </div>

            <!-- Input Fields Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Left Column -->
                <div class="space-y-5">
                    <!-- Property Name -->
                    <div>
                        <label for="propertyName" class="block text-sm font-medium text-gray-700">Property Name</label>
                        <input type="text" id="propertyName" name="propertyName" placeholder="Enter property name"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="E.g. 19800000"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Post Type -->
                    <div>
                        <label for="postType" class="block text-sm font-medium text-gray-700">Post Type</label>
                        <select id="postType" name="postType"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm"
                            required>
                            <option value="">Select type</option>
                            <option value="Sale">Sale</option>
                            <option value="Rent">Rental</option>
                        </select>
                    </div>

                    <!-- Bathroom Count -->
                    <div id="bathroomFields" style="display: none;">
                        <label for="bathroomCount" class="block text-sm font-medium text-gray-700">Bathroom
                            Count</label>
                        <input type="number" id="bathroomCount" name="bathroomCount"
                            placeholder="Enter number of bathrooms"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Measurement -->
                    <div id="measurementFields" style="display: none;">
                        <label for="measurement" class="block text-sm font-medium text-gray-700">Measurement</label>
                        <input type="number" id="measurement" name="measurement" placeholder="E.g. 2000 sqft"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-5">
                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location" placeholder="Enter location"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Property Type -->
                    <div>
                        <label for="propertyType" class="block text-sm font-medium text-gray-700">Property Type</label>
                        <select id="propertyType" name="propertyType" onchange="toggleFields()"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm"
                            required>
                            <option value="">Select type</option>
                            <option value="House">House</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Villa">Villa</option>
                            <option value="Bungalow">Bungalow</option>
                            <option value="Land">Land</option>
                        </select>
                    </div>

                    <!-- Bedroom Count -->
                    <div id="bedroomFields" style="display: none;">
                        <label for="bedroomCount" class="block text-sm font-medium text-gray-700">Bedroom Count</label>
                        <input type="number" id="bedroomCount" name="bedroomCount"
                            placeholder="Enter number of bedrooms"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Floor Count -->
                    <div id="floorsFields" style="display: none;">
                        <label for="floorCount" class="block text-sm font-medium text-gray-700">Number of
                            Floors</label>
                        <input type="number" id="floorCount" name="floorCount" placeholder="Enter number of floors"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Perches -->
                    <div id="perchesFields" style="display: none;">
                        <label for="perches" class="block text-sm font-medium text-gray-700">Perches</label>
                        <input type="number" id="perches" name="perches" placeholder="Enter number of perches"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-6 pt-6 border-t">
                <button type="submit"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg shadow-md hover:bg-blue-700 transition-all w-[120px]">
                    <i class="fas fa-paper-plane"></i>
                    <span>Post</span>
                </button>

                <a href="{{ url()->previous() ?? route('member.property.pending') }}"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 bg-red-500 text-white font-medium rounded-lg shadow-md hover:bg-red-600 transition-all w-[120px]">
                    <i class="fas fa-times"></i>
                    <span>Discard</span>
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Image uploder
            function handleImageUpload(event) {
                const files = event.target.files;
                const previewContainer = document.getElementById('imagePreviewContainer');
                const placeholderText = document.getElementById('placeholderText');

                previewContainer.innerHTML = '';

                if (files.length > 6) {
                    showInfo('You can upload up to 6 images only.');
                    event.target.value = '';
                    placeholderText.style.display = "block";
                    return;
                }

                placeholderText.style.display = "none";

                // Loop and show previews
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = "Preview";
                        img.classList.add(
                            'w-32', 'h-32',
                            'object-cover',
                            'rounded-lg',
                            'border',
                            'shadow'
                        );
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(files[i]);
                }
            }

            // Input field visibility
            function toggleFields() {
                const type = document.getElementById("propertyType").value;
                const showCommon = ["House", "Villa", "Bungalow"];
                const bedroom = document.getElementById("bedroomFields");
                const bathroom = document.getElementById("bathroomFields");
                const floors = document.getElementById("floorsFields");
                const measurement = document.getElementById("measurementFields");
                const perches = document.getElementById("perchesFields");

                // Reset visibility
                bedroom.style.display = "none";
                bathroom.style.display = "none";
                floors.style.display = "none";
                measurement.style.display = "none";
                perches.style.display = "none";

                if (showCommon.includes(type)) {
                    bedroom.style.display = "block";
                    bathroom.style.display = "block";
                    floors.style.display = "block";
                    measurement.style.display = "block";
                    perches.style.display = "block";
                } else if (type === "Commercial") {
                    measurement.style.display = "block";
                    floors.style.display = "block";
                } else if (type === "Apartment") {
                    bedroom.style.display = "block";
                    bathroom.style.display = "block";
                    measurement.style.display = "block";
                    floors.style.display = "block";
                } else if (type === "Land") {
                    perches.style.display = "block";
                }
            }

            // Create a post
            document.getElementById('postAdForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                const images = form.querySelector('#imageInput').files;
                if (images.length === 0) {
                    showInfo('You must upload at least one image.');
                    return;
                }

                try {
                    const response = await axios.post(`/api/propertyAd`, formData, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Content-Type': 'multipart/form-data',
                        }
                    });

                    if (response.data.success) {
                        showSuccess(response.data.success);

                        setTimeout(() => {
                            window.location.href = response.data.redirect_url;
                        }, 1500);

                        form.reset();
                        document.getElementById('imagePreviewContainer').innerHTML =
                            '<span id="placeholderText" class="col-span-3 text-gray-500 text-sm py-6">Upload up to 6 images</span>';
                    } else {
                        showError(response.data.error || 'Something went wrong.');
                    }
                } catch (error) {
                    console.error('Axios error:', error);
                    const msg = error.response?.data?.error || 'Something went wrong.';
                    showError(msg);
                }
            });

            // Show message
            function showSuccess(msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: msg,
                    confirmButtonColor: '#28a745'
                });
            }

            function showInfo(msg) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Notice',
                    text: msg,
                    confirmButtonColor: '#ff9800'
                });
            }

            function showError(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#dc3545'
                });
            }
        </script>
    @endpush

</x-app-layout>
