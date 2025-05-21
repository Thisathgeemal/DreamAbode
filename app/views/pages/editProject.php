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
</head>

<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <section class="bg-white flex items-center justify-center px-2 py-8">
        <div class="bg-white p-8 rounded-xl max-w-3xl w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-4xl font-bold mb-6 mt-3 text-center">Update Your Project</h2>

            <!-- Top Image Section -->
            <form action="./updateProject" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto p-6 bg-white">
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
                        <!-- Project Name -->
                        <div class="mb-2">
                            <label for="projectName" class="block text-md font-medium text-gray-700">Project Name</label>
                            <input type="text" id="projectName" name="projectName" placeholder="Enter project name" value="<?php echo htmlspecialchars($projectDetails['ProjectName'] ?? ''); ?>"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                        </div>

                        <!-- Price -->
                        <div class="mb-2">
                            <label for="price" class="block text-md font-medium text-gray-700">Price</label>
                            <input type="number" id="price" name="price" step="0.01" placeholder="E.g. 19.8M" value="<?php echo htmlspecialchars($projectDetails['Price'] ?? ''); ?>"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                        </div>

                        <!-- Total Units -->
                        <div class="mb-2">
                            <label for="totalUnits" class="block text-md font-medium text-gray-700">Total Units</label>
                            <input type="number" id="totalUnits" name="totalUnits" placeholder="Enter total units" value="<?php echo htmlspecialchars($projectDetails['TotalUnits'] ?? ''); ?>"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <!-- Location -->
                        <div class="mb-2">
                            <label for="location" class="block text-md font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location" placeholder="Enter location" value="<?php echo htmlspecialchars($projectDetails['Location'] ?? ''); ?>"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                                required>
                        </div>

                        <!-- Completion Date -->
                        <div class="mb-2">
                            <label for="completionDate" class="block text-md font-medium text-gray-700">Completion Date</label>
                            <input type="date" id="completionDate" name="completionDate" value="<?php echo htmlspecialchars($projectDetails['CompletionDate'] ?? ''); ?>"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <!-- Measurement -->
                        <div class="mb-2">
                            <label for="measurement" class="block text-md font-medium text-gray-700">Measurement (sqft)</label>
                            <input type="text" id="measurement" name="measurement" placeholder="E.g. 2000" value="<?php echo htmlspecialchars($projectDetails['Measurement'] ?? ''); ?>"
                                class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>
                </div>

                <div class="flex justify-center space-x-4 mt-6">
                    <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 w-[100px]">Update</button>
                    <a href="./discardPathProject"><button type="button" class="bg-red-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-600 w-[100px]">Discard</button></a>
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
    </script>

</html>
