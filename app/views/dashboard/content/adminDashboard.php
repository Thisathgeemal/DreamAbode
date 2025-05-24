<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);
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
    <!-- Main Content -->
    <div class="flex items-center justify-center min-h-screen px-2">
        <div class="flex-1 p-4 sm:p-8 overflow-auto justify-center align-middle max-w-6xl w-full">
            <h1 class="text-3xl sm:text-4xl font-bold mb-8 sm:mb-12 text-center">Welcome to Admin Dashboard!</h1>
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-12">
                    <!-- Card 1 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2">Admins</h2>
                        <p class="text-gray-600 text-xl sm:text-2xl font-bold"><?php echo $adminCount ?></p>
                    </div>
                    <!-- Card 2 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2">Agents</h2>
                        <p class="text-gray-600 text-xl sm:text-2xl font-bold"><?php echo $agentCount ?></p>
                    </div>
                    <!-- Card 3 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2">Members</h2>
                        <p class="text-gray-600 text-xl sm:text-2xl font-bold"><?php echo $memberCount ?></p>
                    </div>
                    <!-- Card 4 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2">Pending Property</h2>
                        <p class="text-gray-600 text-xl sm:text-2xl font-bold"><?php echo $pendingPropertyCount ?></p>
                    </div>
                    <!-- Card 5 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2">Accepted Ads</h2>
                        <p class="text-gray-600 text-xl sm:text-2xl font-bold"><?php echo $acceptAdCount ?></p>
                    </div>
                    <!-- Card 6 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-lg sm:text-xl font-semibold mb-2">Pending Projects</h2>
                        <p class="text-gray-600 text-xl sm:text-2xl font-bold"><?php echo $pendingProjectCount ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>