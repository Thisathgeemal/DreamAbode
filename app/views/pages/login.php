<?php
    require_once __DIR__ . '/../../utils/CookieHelper.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $username = getSecureCookie('username');
    $password = getSecureCookie('password');

    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    unset($_SESSION['message']);

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

    <section class="bg-white flex items-center justify-center px-2 py-8">
        <div class="bg-white p-8 rounded-xl max-w-md w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)] ">
            <form method="POST" action="./login/login">
                <h2 class="text-4xl font-bold mb-7 text-center">Login</h2>

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
                    <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($username) ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="mb-2">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($password) ?>" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                </div>

                <div class="flex items-center justify-between mt-3">
                    <label class="flex items-center text-gray-700 text-sm mt2">
                        <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-green-500 focus:ring-green-500 rounded"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php if ($username) {echo 'checked';}?>>
                        <span class="ml-2 text-sm ">Remember me</span>
                    </label>
                    <a href="#" class="inline-block align-baseline font-semibold text-sm text-green-500 hover:text-green-700">Forgot Password?</a>
                </div>

                <input type="hidden" name="action" id="loginAction" value="">

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <button type="submit" name="login_type" value="admin" class="bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Admin
                    </button>
                    <button type="submit" name="login_type" value="agent" class="bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Agent
                    </button>
                </div>

                <button type="submit" name="login_type" value="member" class="w-full bg-green-400  hover:bg-green-200 text-black font-semibold mt-4 py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">Login</button>

                <div class="text-center mt-2">
                    <p class="inline-block font-semibold text-sm text-black align-middle">Need a new account?
                        <span class="text-green-500 hover:text-green-700">
                            <a href="./registration">Sign up</a>
                        </span>
                    </p>
                </div>
            </form>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
