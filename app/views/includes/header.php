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

    <nav class="p-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-evenly">
            <!-- Logo -->
            <div class="flex items-center justify-center w-full md:w-auto">
            <img src="/DreamAbode/public/images/Logo.png" alt="Dream Abode Logo" class="w-28">
            </div>

            <!-- Desktop Nav Items -->
            <ul class="hidden md:flex space-x-8 ml-8">
                <?php foreach ($navItems as $slug => $label): ?>
                    <li>
                    <a href="./<?php echo $slug ?>"
                    class="transition duration-300 ease-in-out font-semibold text-xl                                                                                                                                                                                                                                                             <?php echo isActive($slug, $currentPage) ?>">
                        <?php echo $label ?>
                    </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Icons (Mobile: below logo, centered; Desktop: right side) -->
            <div class="flex items-center justify-center space-x-4 mt-0 md:mt-0 md:ml-0 md:justify-end w-full md:w-auto">
                <a href="#" class="rounded-full shadow-md">
                    <img src="/DreamAbode/public/images/Favourite.png" alt="Favourite" class="w-8 h-8">
                </a>
                <a href="<?php echo $profileLink ?>" class="rounded-full shadow-md">
                    <img src="/DreamAbode/public/images/User.png" alt="User" class="w-8 h-8">
                </a>
                <!-- Hamburger Menu (Mobile) -->
                <button id="menu-toggle" class="md:hidden">
                    <img src="/DreamAbode/public/images/Menu.png" alt="Menu" class="w-8 h-8">
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 bg-white rounded-lg shadow-lg p-4 transition-all duration-300">
            <ul class="flex flex-col items-center space-y-4">
            <?php foreach ($navItems as $slug => $label): ?>
                <li>
                <a href="./<?php echo $slug ?>"
                class="font-semibold text-lg px-6 py-2 rounded-full transition-colors duration-200 hover:bg-blue-100 hover:text-blue-700                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo isActive($slug, $currentPage) ?>">
                    <?php echo $label ?>
                </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
