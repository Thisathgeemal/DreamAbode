<?php
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

    <section class="flex items-center justify-center bg-white m-15 poppins">
        <div class="bg-white p-15 rounded-2xl max-w-md text-center shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h1 class="text-4xl font-bold text-red-600 mb-4">403</h1>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Unauthorized Access</h2>
            <p class="text-gray-600 mb-6">You do not have permission to view this page.</p>
            <a href="/DreamAbode/public/login" class="inline-block px-6 py-2 bg-[#5CFFAB] text-black font-medium rounded-lg hover:bg-[#32e38d] transition duration-200">
                Go to Login
            </a>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
