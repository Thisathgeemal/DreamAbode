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
</head>

<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <section class="flex justify-center items-start mt-10 space-x-8 px-4">
        <div class="bg-white p-6 rounded-xl flex flex-col justify-center items-center space-y-8 w-[280px] h-[700px] shadow-[0_0_15px_4px_rgba(0,0,0,0.2)]">
            <form method="GET" class="flex flex-col items-center space-y-8">
                <button name="section" value="dashboard" class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-4 px-6 rounded-lg w-[190px] transition-colors duration-200">
                    Dashboard
                </button>
                <button name="section" value="manage_ad" class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-4 px-6 rounded-lg w-[190px] transition-colors duration-200">
                    Manage Ads
                </button>
                <button name="section" value="membership" class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-4 px-6 rounded-lg w-[190px] transition-colors duration-200">
                    Membership
                </button>
                <button name="section" value="saved_properties" class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-4 px-6 rounded-lg w-[190px] transition-colors duration-200">
                    Saved Properties
                </button>
                <button name="section" value="profile" class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-4 px-6 rounded-lg w-[190px] transition-colors duration-200">
                    My Profile
                </button>
                <a href="./login/logout" class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-4 px-6 rounded-lg w-[190px] text-center transition-colors duration-200">
                    Log Out
                </a>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl flex flex-col justify-center items-center space-y-4 w-[65%] h-[700px] shadow-[0_0_15px_4px_rgba(0,0,0,0.2)]">
            <?php
                $section = $_GET['section'] ?? 'default';

                switch ($section) {
                    case 'dashboard':
                        require_once __DIR__ . '/content/dashboard.php';
                        break;
                    case 'profile':
                        require_once __DIR__ . '/content/profile.php';
                        break;
                    case 'manage_ad':
                        require_once __DIR__ . '/content/manageAd.php';
                        break;
                    case 'membership':
                        require_once __DIR__ . '/content/membership.php';
                        break;
                    case 'saved_properties':
                        require_once __DIR__ . '/content/savedProperties.php';
                        break;
                    default:
                        require_once __DIR__ . '/content/dashboard.php';
                }
            ?>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
