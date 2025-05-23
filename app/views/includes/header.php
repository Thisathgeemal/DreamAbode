<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="../../../public/css/styles.css" rel="stylesheet">
</head>
<body>

    <?php require_once __DIR__ . '/../../controllers/navbarController.php'; ?>

    <nav class="p-2">
        <div class="container mx-auto flex justify-evenly items-center">
            <div class="flex items-center">
                <img src="/DreamAbode/public/images/Logo.png" alt="Dream Abode Logo">
            </div>

            <ul class="flex space-x-8">
                <?php foreach ($navItems as $slug => $label): ?>
                    <li>
                        <a href="./<?php echo $slug ?>"
                        class="transition duration-300 ease-in-out font-semibold text-xl                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo isActive($slug, $currentPage) ?>">
                            <?php echo $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="flex items-center justify-around space-x-4">
                <a href="#" class="rounded-full shadow-md">
                    <img src="/DreamAbode/public/images/Favourite.png" alt="Favourite" class="w-8 h-8">
                </a>
                <a href="<?php echo $profileLink ?>" class="rounded-full shadow-md">
                    <img src="/DreamAbode/public/images/User.png" alt="User" class="w-8 h-8">
                </a>
            </div>
        </div>
    </nav>

</body>
</html>
