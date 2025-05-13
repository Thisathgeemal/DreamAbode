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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <section class="bg-white flex items-center justify-center px-4 py-8">
        <div class="bg-white p-8 rounded-xl max-w-md w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <form method="POST" action="./member/signupMember">
                <h2 class="text-4xl font-bold mb-7 text-center">Sign Up</h2>

                <div class="mb-2">
                    <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : ''; ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-2">
                    <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-2">
                    <label for="mobile" class="block text-lg font-medium text-gray-700">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" value="<?php echo isset($_SESSION['form_data']['mobile']) ? htmlspecialchars($_SESSION['form_data']['mobile']) : ''; ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-2">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" value="<?php echo isset($_SESSION['form_data']['password']) ? htmlspecialchars($_SESSION['form_data']['password']) : ''; ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-2">
                    <label for="confirmPassword" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" value="<?php echo isset($_SESSION['form_data']['confirmPassword']) ? htmlspecialchars($_SESSION['form_data']['confirmPassword']) : ''; ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <button type="submit" class="w-full bg-green-400  hover:bg-green-200 text-black font-semibold mt-4 py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">Sign Up</button>
                </form>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

    <?php if (isset($_SESSION['msg'])): ?>

    <?php
        $message  = htmlspecialchars($_SESSION['msg']);
        $icon     = (strpos($message, "successfully") !== false) ? "success" : "error";
        $title    = ($icon === "success") ? "Success" : "Error";
        $redirect = $_SESSION['redirect'] ?? null;

        if ($icon === "success") {
            unset($_SESSION['form_data']);
        }

        unset($_SESSION['msg']);
        unset($_SESSION['redirect']);
    ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: '<?php echo $icon; ?>',
                    title: '<?php echo $title; ?>',
                    text: '<?php echo $message; ?>',
                    confirmButtonColor: '#5CFFAB',
                    confirmButtonText: '<?php echo $redirect ? "Continue" : "OK"; ?>',
                    customClass: {
                        confirmButton: 'tailwind-confirm-btn'
                    }
                }).then((result) => {
                    <?php if ($redirect): ?>
                        if (result.isConfirmed) {
                            window.location.href = '<?php echo $redirect; ?>';
                        }
                    <?php endif; ?>
                });
            });
        </script>
    <?php endif; ?>

</body>
</html>
