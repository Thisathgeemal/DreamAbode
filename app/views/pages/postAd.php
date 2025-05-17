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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <div id="imagePreviewContainer" class="bg-gray-200 h-[250px] w-[250px] mx-auto rounded-lg flex items-center justify-center mb-8">
                        <span id="placeholderText" class="text-gray-500">Upload up to 6 images at once</span>
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
                                required>
                                <option value="">Select type</option>
                                <option value="House">House</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Villa">Villa</option>
                                <option value="Bangalore">Bangalore</option>
                                <option value="Land">Land</option>
                            </select>
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

                        <!-- Price -->
                        <div class="mb-2">
                            <label for="price" class="block text-md font-medium text-gray-700">Price</label>
                            <input type="number" id="price" name="price" step="0.01" placeholder="Enter price"
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
                    </div>
                </div>

                <div class="flex justify-center space-x-4 mt-6">
                    <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 w-[100px]">Post</button>
                    <a href="./memberProfile"><button type="button" class="bg-red-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-600 w-[100px]">Discard</button></a>
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
                    img.classList.add('w-24', 'h-24', 'object-cover', 'rounded', 'border', 'shadow');
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(files[i]);
            }
        }
    </script>

</body>
</html>
