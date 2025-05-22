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
            <h1 class="text-4xl font-bold mb-12 text-center">Welcome to Agent Dashboard!</h1>
            <div>
                <div class="grid grid-cols-2 gap-12">
                    <!-- Card 1 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Assigned Properties</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $assignProperty ?></p>
                    </div>
                    <!-- Card 2 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Assigned Projects</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $assignProject ?></p>
                    </div>
                    <!-- Card 3 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Calls Received</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $receivedCall ?></p>
                    </div>
                    <!-- Card 4 -->
                    <div class="custom-dashboard-button custom-dashboard-button:hover">
                        <h2 class="text-xl font-semibold mb-2">Emails Received</h2>
                        <p class="text-gray-600 text-2xl font-bold"><?php echo $receivedEmail ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>