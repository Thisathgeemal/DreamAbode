<!DOCTYPE html>
<html lang="en">
<?php
    define('BASE_URL', '/DreamAbode');
?>

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

    <!-- hero section 1 -->
    <section>
        <!-- text  -->
        <div class="absolute top-[33%] left-[7%] w-[45%] h-[75%]">
            <h1>Member profile</h1>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[23.25%] left-[46%] w-[48%] h-[58%]">
                <img src="./images/HomeBgOne.png" alt="Home Bg">
            </div>

            <!-- ad post button -->
            <a href="./postAd" class="z-50 absolute top-[91%] left-[81%] w-[8.75%] h-[5.5%]">
                <div class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative">
                    <div class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[20%] left-[35%] text-[0.9vw] text-black font-medium">Post Your Ad</span>
                </div>
            </a>
        </div>

    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
