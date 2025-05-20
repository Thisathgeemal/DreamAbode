<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['viewProperty'])) {
        $viewProperty = $_SESSION['viewProperty'];
        $images       = $viewProperty['ImageData'];
    }

    define('BASE_URL', '/DreamAbode');
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

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <!-- hero section 1 -->
    <section class="bg-white p-6 flex flex-col items-center">
        <div class="relative mb-10">
            <?php if (! empty($images)): ?>
                <img src="data:image/jpeg;base64,<?php echo $images[0]; ?>" alt="Main Property" class="relative z-10 w-[550px] rounded-lg border border-black shadow-md hover:scale-105 transition-transform duration-300">
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-5 gap-6 px-20">
            <?php if (! empty($images) && count($images) > 1): ?>
<?php foreach (array_slice($images, 1) as $img): ?>
                    <img src="data:image/jpeg;base64,<?php echo $img; ?>" alt="Property Image" class="max-w-[200px] rounded-lg border border-black shadow-md hover:scale-105 transition-transform duration-300">
                <?php endforeach; ?>
<?php endif; ?>
        </div>
    </section>

    <!-- hero section 2 -->
    <section class="max-w-6xl mx-auto bg-white rounded-lg p-6 mt-10 shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold text-gray-800 mt-3 mb-5"><?php echo $viewProperty['PropertyName']; ?></h2>
            <p class="text-gray-600 flex justify-center items-center gap-2 text-md font-semibold">
                <img src="./images/Location.png" alt="Location" class="w-6 h-7">
                <?php echo $viewProperty['Location']; ?>
            </p>
        </div>

        <!-- Price -->
        <div class="flex justify-center mt-6">
            <div class="inline-flex items-center gap-2 px-6 py-2 border border-gray-300 rounded-lg bg-green-100 text-red-600 font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/money.png" alt="Money" class="w-6 h-7">
                RS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php echo $viewProperty['Price']; ?> M
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 my-8 mx-[20%]">
            <!-- Feature Box Template -->
            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Houses.png" alt="House" class="w-6 h-6">
                <?php echo $viewProperty['PropertyType']; ?>
            </div>

            <div class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Bedrooms.png" alt="Bedroom" class="w-6 h-6">
                <?php echo $viewProperty['Bedrooms']; ?> Bedrooms
            </div>

            <div class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Bathrooms.png" alt="Bathroom" class="w-6 h-6">
                <?php echo $viewProperty['Bathrooms']; ?> Bathrooms
            </div>

            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Perches.png" alt="Sq.Ft" class="w-6 h-6">
                <?php echo $viewProperty['Measurement']; ?> Sq.Ft.
            </div>

            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Floor.png" alt="Floor" class="w-6 h-6">
                <?php echo $viewProperty['Floors']; ?> Floor
            </div>

            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Perches.png" alt="Perches" class="w-6 h-6">
                <?php echo $viewProperty['Perches']; ?> Perches
            </div>
        </div>
    </section>

    <!-- hero section 3 -->
    <section class="max-w-6xl mx-auto bg-white rounded-lg p-6 mt-14 shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold text-gray-800 mt-3 mb-5">Explore Neighborhood</h2>
        </div>

        <div class="max-w-3xl mx-auto my-10">
            <div class="overflow-hidden rounded-lg border border-gray-300 shadow-[0_0_10px_3px_rgba(92,115,114,0.25)]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63320.41806481885!2d80.5844958207122!3d7.294628564856129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae366266498acd3%3A0x411a3818a1e03c35!2sKandy!5e0!3m2!1sen!2slk!4v1747724701689!5m2!1sen!2slk"
                    width="100%"
                    height="300"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-[300px]">
                </iframe>
            </div>
        </div>
    </section>

    <!-- hero section 4 -->
    <section class="max-w-6xl mx-auto bg-white rounded-lg p-6 mt-14 shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold text-gray-800 mt-3 mb-5">Contact Agent</h2>
        </div>

        <div class="flex flex-col md:flex-row items-center md:justify-center gap-10 my-10">
            <!-- Profile Image -->
            <div class="flex-shrink-0">
                <img src="./images/profile.png" alt="Agent" class="w-30 h-30 rounded-full border object-cover shadow-md" />
            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                <button class="bg-[#5CFFAB] text-black font-semibold py-2 px-8 rounded-lg flex items-center justify-center border border-gray-400 gap-2 shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                    <img src="./images/Call.png" alt="Call" class="w-5 h-5">
                    Call
                </button>
                <button class="bg-[#5CFFAB] text-black font-semibold py-2 px-8 rounded-lg flex items-center justify-center border border-gray-400 gap-2 shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                    <img src="./images/Email.png" alt="Email" class="w-6 h-6">
                    Email
                </button>
            </div>
        </div>

        <!-- Contact Form -->
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-[15%] mb-8">
            <input type="text" placeholder="Name" class="bg-green-100 p-3 rounded border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-none" required />
            <textarea placeholder="Message" class="bg-green-100 p-3 rounded h-full md:row-span-3 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-none" required></textarea>
            <input type="email" placeholder="Email" class="bg-green-100 p-3 rounded focus:outline-none border border-gray-500 focus:ring-2 focus:ring-green-400 focus:border-none" required/>
            <input type="tel" placeholder="Contact Number" class="bg-green-100 p-3 rounded border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-none" required/>
        </form>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';

        unset($_SESSION['viewProperty']);
    ?>

</body>
</html>
