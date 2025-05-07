<?php
    require_once '../../../config/database.php';
    require_once '../../controllers/MemberController.php';

    $database   = new Database();
    $conn       = $database->connection();
    $controller = new MemberController($conn);
    $massage    = $controller->signupMember();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="../../../public/css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include '../includes/header.php'?>

    <section class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full">
        <form method="POST" action="">
            <h2 class="text-4xl font-bold mb-7 text-center">Sign Up</h2>

            <div class="mb-2">
                <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <div class="mb-2">
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <div class="mb-2">
                <label for="mobile" class="block text-lg font-medium text-gray-700">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <div class="mb-2">
                <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <div class="mb-2">
                <label for="confirmPassword" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>

            <button type="submit" class="w-full bg-green-400  hover:bg-green-200 text-black font-semibold mt-4 py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">Sign Up</button>
            </form>
    </div>
    </section>

    <?php if (! empty($massage)): ?>
    <script>
        Swal.fire({
            title: 'Message',
            text: "<?php echo addslashes($massage); ?>",
            icon: "<?php echo(strpos(strtolower($massage), 'success') !== false) ? 'success' : 'error'; ?>",
            confirmButtonText: 'OK',
            confirmButtonColor: '#10B981'
        });
    </script>
    <?php endif; ?>

</body>
</html>
