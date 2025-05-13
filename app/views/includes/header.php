<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="../../../public/css/styles.css" rel="stylesheet">
</head>
<body>
<?php
    $uri = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    $currentPage = $uri ?: 'home';

    function activeClass($page, $currentPage)
    {
        return ($page === $currentPage)
        ? 'border-b-4 border-[#5CFFAB]'
        : '';
    }
?>

    <nav class="p-2">
        <div class="container mx-auto flex justify-evenly items-center">

            <div class="flex items-center">
                <img src="/DreamAbode/public/images/Logo.png" alt="Dream Abode Logo">
            </div>

            <ul class="flex space-x-8">
                <li>
                    <a href="./home"
                    class="transition duration-300 ease-in-out font-semibold text-xl
                    <?php echo activeClass('home', $currentPage); ?>">
                    Home
                    </a>
                </li>
                <li>
                    <a href="./sales"
                    class="transition duration-300 ease-in-out font-semibold text-xl
                    <?php echo activeClass('sales', $currentPage); ?>">
                    Sales
                    </a>
                </li>
                <li>
                    <a href="./rentals"
                    class="transition duration-300 ease-in-out font-semibold text-xl
                    <?php echo activeClass('rentals', $currentPage); ?>">
                    Rentals
                    </a>
                </li>
                <li>
                    <a href="./projects"
                    class="transition duration-300 ease-in-out font-semibold text-xl
                    <?php echo activeClass('projects', $currentPage); ?>">
                    Projects
                    </a>
                </li>
                <li>
                    <a href="./loans"
                    class="transition duration-300 ease-in-out font-semibold text-xl
                    <?php echo activeClass('loans', $currentPage); ?>">
                    Loans
                    </a>
                </li>
                <li>
                    <a href="./about"
                    class="transition duration-300 ease-in-out font-semibold text-xl
                    <?php echo activeClass('about', $currentPage); ?>">
                    About
                    </a>
                </li>
            </ul>

            <div class="flex items-center justify-around space-x-4 ">
                <a href="#" class="rounded-full shadow-md">
                    <img src="/DreamAbode/public/images/Favourite.png" alt="Favourite" class="w-8 h-8">
                </a>
                <a href="./login" class="rounded-full shadow-md">
                    <img src="/DreamAbode/public/images/User.png" alt="Favourite" class="w-8 h-8">
                </a>
            </div>

        </div>
    </nav>


</body>
</html>
