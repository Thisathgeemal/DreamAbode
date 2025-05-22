<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="<?php echo BASE_URL . "/public/css/styles.css" ?>" rel="stylesheet">
</head>

<body>

        <section id="property-container-accept" class="flex flex-wrap gap-10 justify-center p-4 h-[475px] overflow-y-auto custom-scrollbar">
            <?php if (! empty($assignProperties) && is_array($assignProperties)): ?>
<?php foreach ($assignProperties as $prop): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
                <!-- property image  -->
                <div class="relative">
                    <?php if (! empty($prop['ImageData'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($prop['ImageData']) ?>" alt="Property Image" class="w-full h-60 object-cover">
                    <?php endif; ?>
                    <div class="absolute top-2 right-2 bg-white rounded-lg p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                        <span class="font-semibold"><?php echo htmlspecialchars($prop['PostType']) ?></span>
                    </div>
                </div>

                <!-- property data  -->
                <div class="p-4 bg-[#5CFFAB] text-black text-center">
                    <h2 class="text-xl font-bold m-1"><?php echo htmlspecialchars($prop['PropertyName']) ?></h2>
                    <div class="flex justify-center items-center space-x-2 my-4">
                        <img src="./images/Location.png" alt="Location" class="h-7 w-5.5">
                        <span>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php echo htmlspecialchars($prop['Location']) ?> </span>
                    </div>

                    <div class="flex justify-center items-center mt-2 space-x-8">
                        <div class="flex items-center space-x-2">
                            <img src="./images/money.png" alt="Price" class="h-7 w-7 mr-2">
                            <span>RS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo htmlspecialchars($prop['Price']) ?> M</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img src="./images/Bedrooms.png" alt="Bedrooms" class="h-6 w-6 mr-2">
                            <span><?php echo htmlspecialchars($prop['Bedrooms']) ?> Rooms</span>
                        </div>
                    </div>

                    <!-- buttons -->
                    <?php if ($prop['Status'] === 'Accept'): ?>
                        <form action="./propertyView/viewProperty" method="POST" class="mt-4 space-x-2">
                            <input type="hidden" name="property_id" value="<?php echo $prop['PropertyID'] ?>">
                            <button type="submit" name="action" value="View" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-[100px] transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">View</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
<?php else: ?>
                <p class="flex justify-center align-middle text-center text-red-500 text-lg">No properties found.</p>
            <?php endif; ?>
        </section>

</body>
</html>