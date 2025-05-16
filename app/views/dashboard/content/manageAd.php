<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
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

    <section class="p-10 w-full">
        <div class="flex mb-6">
            <button class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200 mr-8">
                <img src="/DreamAbode/public/images/Add.png" class="w-6 h-6 inline-block mr-1"><a href="./postAd">Add</a>
            </button>
            <button class="bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200">
                <img src="/DreamAbode/public/images/Promote.png" class="w-6 h-6 inline-block mr-1"><a href="#">Promote</a>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>

            </div>
        </div>
    </section>

</body>
</html>