<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Post Your Project Ad</h2>
        <p class="text-sm text-gray-300 mt-1">Easily publish and manage your project listings.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <form id="postProjectForm" class="space-y-8" enctype="multipart/form-data">

            <!-- Image Upload Section -->
            <div>
                <label class="block text-lg font-medium text-gray-700 mb-3 text-center">Project Images</label>
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
                    <!-- Project Name -->
                    <div>
                        <label for="projectName" class="block text-sm font-medium text-gray-700">Project Name</label>
                        <input type="text" id="projectName" name="projectName" placeholder="Enter project name"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="E.g. 50000000"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Total Units -->
                    <div>
                        <label for="totalUnits" class="block text-sm font-medium text-gray-700">Total Units</label>
                        <input type="number" id="totalUnits" name="totalUnits" placeholder="Enter total units"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Measurement -->
                    <div>
                        <label for="measurement" class="block text-sm font-medium text-gray-700">Measurement of a Unit
                            (sqft)</label>
                        <input type="number" id="measurement" name="measurement" placeholder="E.g. 2000"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Project Status -->
                    <div>
                        <label for="projectStatus" class="block text-sm font-medium text-gray-700">Project
                            Status</label>
                        <select id="projectStatus" name="projectStatus" onchange="toggleCompletionDate()"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm"
                            required>
                            <option value="">Select status</option>
                            <option value="upcoming">Upcoming</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <!-- Completion Date -->
                    <div id="completionDateField" style="display: none;">
                        <label for="completionDate" class="block text-sm font-medium text-gray-700">Expected Completion
                            Date</label>
                        <input type="date" id="completionDate" name="completionDate"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
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
                        <select id="propertyType" name="propertyType" onchange="toggleApartmentFields()"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm"
                            required>
                            <option value="">Select type</option>
                            <option value="apartment">Apartment</option>
                            <option value="commercial">Commercial</option>
                        </select>
                    </div>

                    <!-- Bedrooms -->
                    <div id="bedroomsField" style="display: none;">
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                        <input type="number" id="bedrooms" name="bedrooms" placeholder="Enter number of bedrooms"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Bathrooms -->
                    <div id="bathroomsField" style="display: none;">
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                        <input type="number" id="bathrooms" name="bathrooms"
                            placeholder="Enter number of bathrooms"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Parking Spaces -->
                    <div>
                        <label for="parkingSpaces" class="block text-sm font-medium text-gray-700">Parking
                            Spaces</label>
                        <input type="number" id="parkingSpaces" name="parkingSpaces"
                            placeholder="Enter parking spaces"
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

                <a href="{{ url()->previous() ?? route('member.project.pending') }}"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 bg-red-500 text-white font-medium rounded-lg shadow-md hover:bg-red-600 transition-all w-[120px]">
                    <i class="fas fa-times"></i>
                    <span>Discard</span>
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";

            // Image uploader
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

                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = "Preview";
                        img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'border', 'shadow');
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(files[i]);
                }
            }

            // Show bedrooms and bathrooms only if property_type is apartment
            function toggleApartmentFields() {
                const type = document.getElementById("propertyType").value;
                const bedroomsField = document.getElementById("bedroomsField");
                const bathroomsField = document.getElementById("bathroomsField");

                if (type === "apartment") {
                    bedroomsField.style.display = "block";
                    bathroomsField.style.display = "block";
                } else {
                    bedroomsField.style.display = "none";
                    bathroomsField.style.display = "none";
                }
            }

            // Show completion date if status is upcoming or ongoing
            function toggleCompletionDate() {
                const status = document.getElementById("projectStatus").value;
                const completionDateField = document.getElementById("completionDateField");

                if (status === "upcoming" || status === "ongoing") {
                    completionDateField.style.display = "block";
                } else {
                    completionDateField.style.display = "none";
                }
            }

            // Create a post
            document.getElementById('postProjectForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                const images = form.querySelector('#imageInput').files;
                if (images.length === 0) {
                    showInfo('You must upload at least one image.');
                    return;
                }

                try {
                    const response = await axios.post(`/api/projectAd`, formData, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
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
                    const msg = error.response?.data?.error || 'Something went wrong.';
                    showError(msg);
                }
            });

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
