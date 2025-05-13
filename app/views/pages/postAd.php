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

            <div class="flex space-x-6">
                <div class="flex-1">
                    <!-- Image preview container -->
                    <div id="imagePreviewContainer" class="bg-gray-200 h-48 rounded-lg flex items-center justify-center mb-4 overflow-x-auto ">
                        <span id="placeholderText" class="text-gray-500">Image Placeholder</span>
                    </div>

                    <input type="file" id="imageInput" name="images[]" multiple accept="image/*" class="hidden" onchange="handleImageUpload(event)" />

                    <button type="button" onclick="document.getElementById('imageInput').click()"
                    class="bg-green-200 text-green-800 font-semibold py-2 rounded-lg hover:bg-green-300 w-[150px]">
                    Add images
                    </button>
                </div>

                <div class="flex-1 space-y-4">
                    <!-- Property Name -->
                    <div class="mb-2">
                        <label for="propertyName" class="block text-md font-medium text-gray-700">Property Name</label>
                        <input type="text" id="propertyName" name="propertyName" placeholder="Enter property name"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>

                    <!-- Location -->
                    <div class="mb-2">
                        <label for="location" class="block text-md font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location" placeholder="Enter location"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>

                    <!-- Price -->
                    <div class="mb-2">
                        <label for="price" class="block text-md font-medium text-gray-700">Price</label>
                        <input type="number" id="price" name="price" placeholder="Enter price"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>

                    <!-- Measurement -->
                    <div class="mb-2">
                        <label for="measurement" class="block text-md font-medium text-gray-700">Measurement (SQFT)</label>
                        <input type="number" id="measurement" name="measurement" placeholder="Enter measurement"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>

                    <!-- Property Type -->
                    <div class="mb-2">
                        <label for="propertyType" class="block text-md font-medium text-gray-700">Property Type</label>
                        <select id="propertyType" name="propertyType"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none focus:ring-2 focus:ring-green-400"
                            onchange="handlePropertyTypeChange()" required>
                            <option value="">Select type</option>
                            <option value="House">House</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Villa">Villa</option>
                            <option value="Bangalore">Bangalore</option>
                            <option value="Land">Land</option>
                        </select>
                    </div>

                    <!-- Hidden section for House or Apartment -->
                    <div id="houseApartmentFields" class="mb-2 hidden">
                        <!-- Bedroom Count -->
                        <div class="mb-2">
                            <label for="bedrooms" class="block text-md font-medium text-gray-700">Bedroom Count</label>
                            <input type="number" id="bedrooms" name="bedrooms" placeholder="Enter number of bedrooms"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <!-- Bathroom Count -->
                        <div class="mb-2">
                            <label for="bathrooms" class="block text-md font-medium text-gray-700">Bathroom Count</label>
                            <input type="number" id="bathrooms" name="bathrooms" placeholder="Enter number of bathrooms"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <!-- Number of Floors -->
                        <div class="mb-2">
                            <label for="floors" class="block text-md font-medium text-gray-700">Number of Floors</label>
                            <input type="number" id="floors" name="floors" placeholder="Enter number of floors"
                            class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>`
                </div>
            </div>


            <div class="flex justify-center space-x-4 mt-6">
                <button class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 w-[100px]">Post</button>
                <button class="bg-red-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-600 w-[100px]">Discard</button>
            </div>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

    <script>
        let uploadedImageURLs = [];

        function handleImageUpload(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');
        const placeholderText = document.getElementById('placeholderText');
        previewContainer.innerHTML = '';
        uploadedImageURLs = []; // reset

        if (files.length === 0) {
            placeholderText.classList.remove('hidden');
            return;
        }

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'h-40 w-auto rounded-lg object-cover';
            previewContainer.appendChild(img);

            // Store Base64 string to mimic saving for post
            uploadedImageURLs.push(e.target.result);
            };
            reader.readAsDataURL(file);
        });
        }

        function showImagesInPost() {
        const postContainer = document.getElementById('postImageContainer');
        postContainer.innerHTML = ''; // clear before displaying
        uploadedImageURLs.forEach(url => {
            const img = document.createElement('img');
            img.src = url;
            img.className = 'w-full h-40 object-cover rounded-lg';
            postContainer.appendChild(img);
        });
        }

    function handlePropertyTypeChange() {
        const selected = document.getElementById('propertyType').value;
        const extraFields = document.getElementById('houseApartmentFields');

        if (selected === 'House' || selected === 'Apartment' || selected === 'Villa' || selected === 'Bangalore') {
        extraFields.classList.remove('hidden');
        } else {
        extraFields.classList.add('hidden');
        }
    }
    </script>

</body>
</html>
