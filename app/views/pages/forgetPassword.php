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

    <section class="bg-white flex items-center justify-center align-middle mt-10">
        <div class="bg-white p-8 rounded-xl max-w-md w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-4xl font-bold mb-7 text-center">Forgot Password</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <p class="text-red-500 font-semibold text-center mb-4"><?php echo $_SESSION['error'];unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <p class="text-green-500 font-semibold text-center mb-4"><?php echo $_SESSION['success'];unset($_SESSION['success']); ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['verified'])): ?>
                <!-- Reset Password Form -->
                <form action="./forgetPassword/resetPassword" method="POST" class="space-y-4">
                    <div>
                        <label for="password" class="block text-lg font-medium text-gray-700">New Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password"
                            class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password"
                            class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>
                    <button type="submit" class="w-full bg-green-400 hover:bg-green-200 text-black font-semibold mt-4 py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">
                        Reset Password
                    </button>
                </form>

            <?php elseif (! isset($_SESSION['verification_code'])): ?>
                <!-- Email Input Form -->
                <form action="./forgetPassword/sendVerificationCode" method="POST" class="space-y-4">
                    <div class="mb-2">
                        <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email"
                            value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>"
                            class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                    </div>
                    <button type="submit" class="w-full bg-green-400 hover:bg-green-200 text-black font-semibold mt-4 py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">
                        Get Verification Code
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="inline-block font-semibold text-sm text-black align-middle">
                        Remembered your password?
                        <span class="text-green-500 hover:text-green-700">
                            <a href="./forgetPassword/resetForgotPassword">Back to Login</a>
                        </span>
                    </p>
                </div>

            <?php else: ?>
                <!-- Verification Code Input Form -->
                <form action="./forgetPassword/verifyCode" method="POST" class="space-y-4">
                    <div class="flex justify-between">
                        <?php for ($i = 0; $i < 6; $i++): ?>
                            <input type="text" name="code[]"
                                maxlength="1"
                                required
                                class="w-10 h-10 text-center border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value) this.nextElementSibling?.focus();"
                                onkeydown="if(event.key === 'Backspace' && !this.value) this.previousElementSibling?.focus();">
                        <?php endfor; ?>
                    </div>
                    <button type="submit" class="w-full bg-green-400 hover:bg-green-200 text-black font-semibold mt-4 py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">
                        Confirm Verification Code
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="inline-block font-semibold text-sm text-black align-middle">
                        Remembered your password?
                        <span class="text-green-500 hover:text-green-700">
                            <a href="./forgetPassword/resetForgotPassword">Back to Login</a>
                        </span>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</body>
</html>