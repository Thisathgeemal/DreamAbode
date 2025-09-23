<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Edit Your Project Ad</h2>
        <p class="text-sm text-gray-300 mt-1">Easily manage your project listings.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <form id="editProjectForm" class="space-y-8" enctype="multipart/form-data" data-id="{{ $projectId }}">
            @csrf

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
                    <div id="completionDateField" style="display:none;">
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
                    <div id="bedroomsField" style="display:none;">
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                        <input type="number" id="bedrooms" name="bedrooms" placeholder="Enter number of bedrooms"
                            class="mt-2 block w-full bg-gray-50 border border-gray-300 rounded-lg shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Bathrooms -->
                    <div id="bathroomsField" style="display:none;">
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
                    <span>Update</span>
                </button>

                <a href="{{ route('member.project.pending') }}"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 bg-red-500 text-white font-medium rounded-lg shadow-md hover:bg-red-600 transition-all w-[120px]">
                    <i class="fas fa-times"></i>
                    <span>Discard</span>
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const projectId = document.getElementById('editProjectForm').dataset.id;

                if (!projectId) return;

                axios.get(`/api/projectAd/${projectId}`, {
                    headers: {
                        'Authorization': `Bearer {{ session('auth_token') }}`
                    }
                }).then(response => {
                    const project = response.data.project;

                    document.getElementById('projectName').value = project.project_name || '';
                    document.getElementById('price').value = project.price || '';
                    document.getElementById('totalUnits').value = project.total_units || '';
                    document.getElementById('measurement').value = project.measurement || '';
                    document.getElementById('location').value = project.location || '';
                    document.getElementById('parkingSpaces').value = project.parking_spaces || '';
                    document.getElementById('bedrooms').value = project.bedrooms || '';
                    document.getElementById('bathrooms').value = project.bathrooms || '';

                    // Project status
                    const statusEl = document.getElementById('projectStatus');
                    if (project.project_status) {
                        for (let option of statusEl.options) {
                            if (option.value.toLowerCase() === project.project_status.toLowerCase()) {
                                option.selected = true;
                                break;
                            }
                        }
                        toggleCompletionDate();
                    }
                    if (project.completion_date) {
                        const formattedDate = project.completion_date.split("T")[0];
                        document.getElementById('completionDate').value = formattedDate;
                    }

                    // Property type
                    const typeEl = document.getElementById('propertyType');
                    if (project.property_type) {
                        for (let option of typeEl.options) {
                            if (option.value.toLowerCase() === project.property_type.toLowerCase()) {
                                option.selected = true;
                                break;
                            }
                        }
                        toggleApartmentFields();
                    }

                    // Images
                    const imageContainer = document.getElementById('imagePreviewContainer');
                    imageContainer.innerHTML = '';
                    if (project.images && project.images.length) {
                        project.images.forEach(img => {
                            const imgEl = document.createElement('img');
                            imgEl.src = `/storage/${img.image_path}`;
                            imgEl.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'border',
                                'shadow');
                            imageContainer.appendChild(imgEl);
                        });
                    } else {
                        imageContainer.innerHTML =
                            '<span class="col-span-3 text-gray-500 text-sm py-6">Upload up to 6 images</span>';
                    }
                }).catch(err => {
                    console.error(err);
                    showError('Failed to fetch project details.');
                });
            });

            // Image uploader (limit 6 images, show preview, match postProject logic)
            function handleImageUpload(event) {
                const files = event.target.files;
                const previewContainer = document.getElementById('imagePreviewContainer');
                const placeholderText = document.getElementById('placeholderText');

                previewContainer.innerHTML = '';

                if (files.length > 6) {
                    showInfo('You can upload up to 6 images only.');
                    event.target.value = '';
                    if (placeholderText) placeholderText.style.display = "block";
                    return;
                }

                if (placeholderText) placeholderText.style.display = "none";

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

            // Update project
            document.getElementById('editProjectForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const projectId = this.dataset.id;
                const formData = new FormData(this);
                formData.append('_method', 'PUT');

                try {
                    const response = await fetch(`/api/projectAd/${projectId}`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showSuccess(data.success);
                        setTimeout(() => {
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            }
                        }, 1500);
                    } else {
                        showError(data.error || 'Failed to update project.');
                    }
                } catch (err) {
                    console.error(err);
                    showError('An unexpected error occurred.');
                }
            });

            function toggleApartmentFields() {
                const type = document.getElementById("propertyType").value;
                document.getElementById("bedroomsField").style.display = type === "apartment" ? "block" : "none";
                document.getElementById("bathroomsField").style.display = type === "apartment" ? "block" : "none";
            }

            function toggleCompletionDate() {
                const status = document.getElementById("projectStatus").value;
                document.getElementById("completionDateField").style.display =
                    (status === "upcoming" || status === "ongoing") ? "block" : "none";
            }

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
