<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (! isset($_SESSION['user_id'])) {
        header('Location: ' . '/DreamAbode/public/login');
        exit;
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
                        <form action="./login/logout" method="post">
                <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-4">
                    Logout
                </button>
            </form>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
