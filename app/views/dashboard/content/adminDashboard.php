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
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex-1 p-8 overflow-auto justify-center align-middle max-w-6xl">
            <h1 class="text-4xl font-bold mb-12 text-center">Welcome to Admin Dashboard!</h1>
            <div>
                <div class="grid grid-cols-3 gap-12">
                    <!-- Card 1 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Admins</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $adminCount ?></p>
                    </div>
                    <!-- Card 2 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Agents</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $agentCount ?></p>
                    </div>
                    <!-- Card 3 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Members</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $memberCount ?></p>
                    </div>
                    <!-- Card 4 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Pending Property</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $pendingPropertyCount ?></p>
                    </div>
                    <!-- Card 5 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Accepted Ads</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $acceptAdCount ?></p>
                    </div>
                    <!-- Card 6 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Pending Projects</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $pendingProjectCount ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>