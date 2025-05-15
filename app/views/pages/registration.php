<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    define('BASE_URL', '/DreamAbode');

    $message  = $_SESSION['message'] ?? '';
    $redirect = $_SESSION['redirect'] ?? null;

    if (! empty($message) && $redirect) {
        if (strpos(strtolower($message), 'success') !== false) {
            unset($_SESSION['form_data']);
        }
        header("Refresh: 2; URL=$redirect");
    }

    unset($_SESSION['message']);
    unset($_SESSION['redirect']);
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

    <section class="bg-white flex items-center justify-center px-4 py-8">
        <div class="bg-white p-8 rounded-xl max-w-md w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <form method="POST" action="./member/signupMember">
                <h2 class="text-4xl font-bold mb-7 text-center">Sign Up</h2>

                <?php if ($message): ?>
<?php
    $colorClass = (strpos(strtolower($message), 'success') !== false)
    ? 'text-green-600'
    : 'text-red-600';
?>
                    <div class="mb-4 text-center font-semibold p-1<?php echo $colorClass; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

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

            <div class="text-center mt-4">
                <p class="inline-block font-semibold text-sm text-black align-middle">
                    Already have an account?
                    <span class="text-green-500 hover:text-green-700">
                        <a href="./login">Back to Login</a>
                    </span>
                </p>
            </div>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
