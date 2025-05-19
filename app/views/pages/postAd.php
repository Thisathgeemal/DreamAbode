<!DOCTYPE html>
<html lang="en">
<?php
    define('BASE_URL', '/DreamAbode');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="<?php echo BASE_URL . "/public/css/styles.css" ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <section class="bg-white flex items-center justify-center px-2 py-8">
        <div class="bg-white p-8 rounded-xl max-w-3xl w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-4xl font-bold mb-7 text-center">Add a Post</h2>

            <!-- Top Image Section -->
            <form action="./postAd/addProperty" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto p-6 bg-white">
                <div class="mb-6 text-center">
                    <div id="imagePreviewContainer" class="grid grid-cols-3 gap-4 justify-items-center w-[600px] mx-auto bg-gray-200 p-4 rounded-lg mt-4 mb-8">
                        <span id="placeholderText" class="text-gray-500"></span>
                        <span id="placeholderText" class="text-gray-500 py-4">Upload up to 6 images at once</span>
                    </div>

                    <input type="file" id="imageInput" name="images[]" multiple accept="image/*" class="hidden" onchange="handleImageUpload(event)" max="6" />

                    <button type="button" onclick="document.getElementById('imageInput').click()"
                        class="bg-green-200 text-black font-semibold py-2 rounded-lg hover:bg-green-300 w-[150px]">
                        Add images
                    </button>
                </div>

                <!-- Input Fields -->
                <div class="flex space-x-6">
                    <div class="flex-1 space-y-4">
                        <!-- Property Name -->
                        <div class="mb-2">
                            <label for="propertyName" class="block text-md font-medium text-gray-700">Property Name</label>
                            <input type="text" id="propertyName" name="propertyName" placeholder="Enter property name"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                        </div>

                        <!-- Price -->
                        <div class="mb-2">
                            <label for="price" class="block text-md font-medium text-gray-700">Price</label>
                            <input type="number" id="price" name="price" step="0.01" placeholder="E.g. 19.8M"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                        </div>

                        <!-- Post Type -->
                        <div class="mb-2">
                            <label for="postType" class="block text-md font-medium text-gray-700">Post Type</label>
                            <select id="postType" name="postType"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                                <option value="">Select type</option>
                                <option value="Sale">Sale</option>
                                <option value="Rental">Rental</option>
                            </select>
                        </div>

                        <!-- Bathroom Count -->
                        <div id="bathroomFields" style="display: none;" class="mb-2">
                            <label for="bathroomCount" class="block text-md font-medium text-gray-700">Bathroom Count</label>
                            <input type="number" id="bathroomCount" name="bathroomCount" placeholder="Enter number of bathrooms"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <!-- Measurement -->
                        <div id="measurementFields" style="display: none;" class="mb-2">
                            <label for="measurement" class="block text-md font-medium text-gray-700">Measurement</label>
                            <input type="text" id="measurement" name="measurement" placeholder="E.g. 2000 sqft"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <!-- Location -->
                        <div class="mb-2">
                            <label for="location" class="block text-md font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location" placeholder="Enter location"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                        </div>

                        <!-- Property Type -->
                        <div id="propertyTypeFields" class="mb-2">
                            <label for="propertyType" class="block text-md font-medium text-gray-700">Property Type</label>
                            <select id="propertyType" name="propertyType"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none focus:ring-2 focus:ring-green-400"
                                required onchange="toggleFields()">
                                <option value="">Select type</option>
                                <option value="House">House</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Villa">Villa</option>
                                <option value="Bangalore">Bangalore</option>
                                <option value="Land">Land</option>
                            </select>
                        </div>

                        <!-- Bedroom Count -->
                        <div id="bedroomFields" style="display: none;" class="mb-2">
                            <label for="bedroomCount" class="block text-md font-medium text-gray-700">Bedroom Count</label>
                            <input type="number" id="bedroomCount" name="bedroomCount" placeholder="Enter number of bedrooms"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <!-- Floor Count -->
                        <div id="floorsFields" style="display: none;" class="mb-2">
                            <label for="floorCount" class="block text-md font-medium text-gray-700">Number of Floors</label>
                            <input type="number" id="floorCount" name="floorCount" placeholder="Enter number of floors"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <!-- Perches -->
                        <div id="perchesFields" style="display: none;" class="mb-2">
                            <label for="perches" class="block text-md font-medium text-gray-700">Perches</label>
                            <input type="number" id="perches" name="perches" placeholder="Enter number of perches"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>
                </div>

                <div class="flex justify-center space-x-4 mt-6">
                    <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 w-[100px]">Post</button>
                    <a href="./memberProfile?section=manage_ad"><button type="button" class="bg-red-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-600 w-[100px]">Discard</button></a>
                </div>
            </form>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

    <script>
        function handleImageUpload(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('imagePreviewContainer');
            const placeholderText = document.getElementById('placeholderText');

            // Clear previous previews
            previewContainer.innerHTML = '';

            if (files.length > 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Too many files!',
                    text: 'You can upload up to 6 images only.',
                    confirmButtonColor: '#16a34a'
                });
                event.target.value = '';
                placeholderText.style.display = "block";
                return;
            }

            placeholderText.style.display = "none";

            // Loop and show previews
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.classList.add('w-38', 'h-38', 'object-cover', 'rounded', 'border', 'shadow');
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(files[i]);
            }
        }

        function toggleFields() {
            const type = document.getElementById("propertyType").value;
            const showCommon = ["House", "Villa", "Bangalore"];
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

    </script>

</body>
</html>
