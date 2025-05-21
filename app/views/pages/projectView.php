<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['viewProject'])) {
        $viewProject = $_SESSION['viewProject'];
        $images      = $viewProject['ImageData'];
    }

    $agent = $_SESSION['agent'] ?? null;

    $message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);

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


    <?php if ($message): ?>
<?php
    $colorClass = (strpos(strtolower($message), 'success') !== false)
    ? 'text-green-600'
    : 'text-red-600';
    echo "<div class=\"mb-4 text-center font-semibold p-1 text-lg " . htmlspecialchars($colorClass) . "\">";
    echo htmlspecialchars($message);
    echo "</div>";
?>
<?php endif; ?>


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
            <h2 class="text-3xl font-bold text-gray-800 mt-3 mb-5">                                                                                                                                                                                                                                                                                                                                                                                                                    <?php echo htmlspecialchars($viewProject['ProjectName']); ?></h2>
            <p class="text-gray-600 flex justify-center items-center gap-2 text-md font-semibold">
                <img src="./images/Location.png" alt="Location" class="w-6 h-7">
                <?php echo $viewProject['Location']; ?>
            </p>
        </div>

        <!-- Price -->
        <div class="flex justify-center mt-6">
            <div class="inline-flex items-center gap-2 px-6 py-2 border border-gray-300 rounded-lg bg-green-100 text-red-600 font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/money.png" alt="Money" class="w-6 h-7">
                RS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php echo htmlspecialchars($viewProject['Price']); ?> M
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 my-8 mx-[20%]">
            <!-- Feature Box Template -->
            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Apartment.png" alt="Apartment" class="w-6 h-6">
                <?php echo htmlspecialchars($viewProject['PropertyType']); ?>
            </div>

            <div class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Units.png" alt="Units" class="w-6 h-6">
                <?php echo htmlspecialchars($viewProject['TotalUnits']); ?> Units
            </div>

            <div class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Accept.png" alt="CompleteDate" class="w-6 h-6">
                <?php echo htmlspecialchars($viewProject['CompletionDate']); ?>
            </div>

            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Perches.png" alt="Sq.Ft" class="w-6 h-6">
                <?php echo htmlspecialchars($viewProject['Measurement']); ?> Sq.Ft.
            </div>

            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/GYM.png" alt="GYM" class="w-7 h-7">
                GYM
            </div>

            <div class="flex items-center justify-center gap-2 px-8 py-3 border border-gray-400 rounded-lg bg-[#5CFFAB] text-black font-semibold shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                <img src="./images/Parking.png" alt="Parking" class="w-6 h-6">
                Parking
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
                <?php $encodedLocation = urlencode($viewProject['Location']); ?>
                <iframe
                    src="https://www.google.com/maps?q=<?php echo $encodedLocation; ?>&output=embed"
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
            <div class="flex-shrink-0">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($agent['Image']) ?>" alt="Agent" class="w-30 h-30 rounded-full border object-cover shadow-md" />
            </div>

            <!-- Buttons (submit form with context) -->
            <div class="flex flex-col gap-3">
                <button type="submit" name="contact_type" value="Call"
                    form="contactForm"
                    class="bg-[#5CFFAB] text-black font-semibold py-2 px-8 rounded-lg flex items-center justify-center border border-gray-400 gap-2 shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                    <img src="./images/Call.png" alt="Call" class="w-5 h-5"> Call
                </button>
                <button type="submit" name="contact_type" value="Email"
                    form="contactForm"
                    class="bg-[#5CFFAB] text-black font-semibold py-2 px-8 rounded-lg flex items-center justify-center border border-gray-400 gap-2 shadow transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-xl">
                    <img src="./images/Email.png" alt="Email" class="w-6 h-6"> Email
                </button>
            </div>
        </div>

        <!-- Contact Form -->
        <form id="contactForm" action="./DreamAbode/public/projectView/sendMessage" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-[15%] mb-8">
            <input type="text" name="name" placeholder="Name" class="bg-green-100 p-3 rounded border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-none" required />
            <textarea name="message" placeholder="Message" class="bg-green-100 p-3 rounded h-full md:row-span-3 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-none"></textarea>
            <input type="email" name="email" placeholder="Email" class="bg-green-100 p-3 rounded focus:outline-none border border-gray-500 focus:ring-2 focus:ring-green-400 focus:border-none" />
            <input type="tel" name="mobile" placeholder="Contact Number" class="bg-green-100 p-3 rounded border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-none" />

            <!-- Hidden IDs -->
            <input type="hidden" name="agent_id" value="<?php echo $viewProject['AgentID'] ?>">
            <input type="hidden" name="project_id" value="<?php echo $viewProject['ProjectID'] ?>">
        </form>
    </section>


    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
