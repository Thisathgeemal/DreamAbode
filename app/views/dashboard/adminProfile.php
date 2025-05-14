<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <!-- hero section 1 -->
    <section>
        <div class="bg-white p-8 rounded shadow-md w-96 text-center">
            <h2 class="text-2xl font-bold text-green-700 mb-4">Welcome, Admin!</h2>
            <p class="text-gray-700">You have successfully logged in as an admin.</p>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
