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

</head>

<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <!-- hero section 1 -->
    <section>
        <!-- text  -->
        <div class="absolute top-[33%] left-[7%] w-[45%] h-[75%]">
            <h1 class="absolute top-0 left-0 text-[3.5vw] font-bold text-black leading-[1.15] poppins">
                Your Trusted <br> Partner in Real <br> Estate
            </h1>
            <h2 class="relative top-[40%] left-0 text-[1.6vw] font-normal text-black poppins">
                We’re your trusted partner in finding the <br> perfect property with integrity, innovation, <br> and personalized service.
            </h2>
            <div class="absolute top-[65%] left-0 w-[34%] h-[9.5%] z-50 bg-[#5CFFAB] rounded-[0.7vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] shadow-md hover:shadow-lg cursor-pointer">
                <span class="absolute top-[20%] w-full text-center text-[1.4vw] text-black font-normal poppins transition-colors duration-300">
                    Discover Our Story
                </span>
            </div>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[23.25%] left-[46%] w-[48%] h-[58%]">
                <img src="./images/AboutOneBg.png" alt="About Bg">
            </div>

            <!-- review button  -->
            <a href="./review" class="z-50 absolute top-[91%] left-[81%] w-[8.75%] h-[5.5%]">
                <div class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative">
                    <div class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[20%] left-[35%] text-[0.9vw] text-black font-medium">Add review</span>
                </div>
            </a>

        </div>

    </section>

        <!-- hero section 2 -->
    <section class="relative mt-[30%] h-[100vh]">
        <!-- background image  -->
        <div class="absolute top-[30%] left-[7%] w-[42%]">
            <img src="./images/AboutTwoBg.png" alt="About Bg" class="transition duration-300 ease-in-out hover:scale-105 hover:shadow-md cursor-pointer">
        </div>

        <div class="absolute top-[30%] left-[48%]">
            <img src="./images/Union.png" alt="Union Bg" class="w-[80%] ">
        </div>

        <!-- text  -->
        <div class="absolute top-[30%] left-[60%] w-[33%] h-[75%]">
            <h1 class="absolute top-0 left-0 text-[3.5vw] font-bold text-black leading-[1.15] poppins">
                Explore Dream Abode
            </h1>
           <h2 class="relative top-[28%] left-0 text-[1.5vw] font-normal text-black text-justify poppins">
                Welcome to Dream Abode, where living meets luxury. We craft exceptional spaces that blend style, comfort, and elegance whether it's a sleek apartment or a grand villa. At Dream Abode, we don't just build homes; we create the kind of living experience that feels like a dream every single day.
            </h2>
        </div>
    </section>

    <!-- hero section 3 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[5%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-[3.5vw] font-bold text-black font-poppins">Get in Touch with Dream Abode</h1>
            <h2 class="text-[1.5vw] text-black font-poppins mt-4">
            Your dream home is just a conversation away! Whether you're looking for your perfect property, need expert real estate advice, or have inquiries about our services, we're here to help. Reach out to us, and let’s turn your vision into reality.
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-wrap justify-center items-center gap-20">
            <!-- Card Item -->
            <div class="w-[550px] h-[550px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <h3 class="text-2xl font-semibold mb-6">Dream Abode Real Estate <br> Colombo</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1978.7698578454135!2d80.63755512941708!3d7.29309175401359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae3662c3b88e9ff%3A0x5b092bc39f5d4ed2!2sSri%20Dalada%20Veediya%2C%20Kandy!5e0!3m2!1sen!2slk!4v1747755707738!5m2!1sen!2slk"
                    width="100%"
                    height="300"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-[300px]">
                </iframe>
                <div class="flex flex-col align-middle justify-center">
                    <h3 class="mt-8">+94 11 234 5678</h3>
                    <h3 class="my-1">info@dreamabode.lk</h3>
                    <h3 class="my-1">123 Luxury Lane, Colombo, Sri Lanka</h3>
                </div>
            </div>

            <div class="w-[550px] h-[550px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <h3 class="text-2xl font-semibold mb-6">Dream Abode Real Estate <br> Kandy</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.0535652958915!2d79.96023731076652!3d7.002975217376222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2f861c6d50e2d%3A0x1347c9fc1104a454!2sKadawatha%20Interchange!5e0!3m2!1sen!2slk!4v1747755781451!5m2!1sen!2slk"
                    width="100%"
                    height="300"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-[300px]">
                </iframe>
                <div class="flex flex-col align-middle justify-center">
                    <h3 class="mt-8">+94 11 234 9856</h3>
                    <h3 class="my-1">kandy@dreamabode.lk</h3>
                    <h3 class="my-1">456 Heritage Street, Kandy, Sri Lanka</h3>
                </div>
            </div>

        </div>
    </section>

    <!-- hero section 4 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[7%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl mx-auto px-2">
            <h1 class="text-3xl sm:text-6xl font-bold text-black poppins text-center">
                Our Journey So Far
            </h1>
            <h2 class="text-lg sm:text-xl text-black poppins mt-7 text-justify sm:text-center leading-relaxed px-5">
                Dream Abode has grown into a trusted name in real estate, delivering quality homes and earning industry recognition.
                With successful projects and happy homeowners, we take pride in every milestone along the way.
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-wrap justify-center items-center gap-10">
            <!-- Card Item -->
            <div class="w-[350px] h-[400px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Award2024.png" alt="Top Innovator in Modern Architecture" class="w-40 h-40 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">2024</h3>
                <h3 class="text-lg font-semibold mb-2">Top Innovator in Modern Architecture</h3>
                <p class="text-sm text-center leading-[2]">We were proud to receive this prestigious award at the National Real Estate Awards, marking a significant milestone in our pursuit of excellence.</p>
            </div>

            <div class="w-[350px] h-[400px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Award2023.png" alt="Excellence in Sustainable Development" class="w-40 h-40 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">2023</h3>
                <h3 class="text-lg font-semibold mb-2">Excellence in Sustainable Development</h3>
                <p class="text-sm text-center leading-[2]">We won the Global Real Estate Sustainability Award for building eco-friendly, energy-efficient homes, supporting a greener future.</p>
            </div>

            <div class="w-[350px] h-[400px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Award2022.png" alt="Best Luxury Developer of the Year" class="w-40 h-40 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">2022</h3>
                <h3 class="text-lg font-semibold mb-2">Best Luxury Developer of the Year</h3>
                <p class="text-sm text-center leading-[2]">We were honored with this prestigious award at the National Real Estate Awards, marking a major achievement in our journey toward excellence</p>
            </div>
        </div>
    </section>

    <!-- hero section 5 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[7%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-[3.5vw] font-bold text-black font-poppins">Our Happy Homeowners</h1>
            <h2 class="text-[1.5vw] text-black font-poppins mt-4">
            Every home has a story, and our clients are the heart of ours. At Dream Abode, we don’t just build houses. We create experiences, lasting relationships, and dream worthy spaces. Hear from our happy homeowners who have made their dream a reality with us.
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-wrap justify-center items-center gap-10">
            <?php if (! empty($randomReviews) && is_array($randomReviews)): ?>
<?php foreach ($randomReviews as $review): ?>
            <!-- Card Item -->
            <div class="w-[350px] h-[400px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <?php
                    $imageSrc = ! empty($review['Image'])
                    ? 'data:image/jpeg;base64,' . base64_encode($review['Image'])
                    : BASE_URL . '/public/images/Profile.png';
                    $username = ! empty($review['Username']) ? ucfirst($review['Username']) : '';
                    $altText  = ! empty($username)
                    ? htmlspecialchars($username . "'s Review")
                    : 'User Review';
                ?>
                <img src="<?php echo $imageSrc; ?>" alt="<?php echo $altText; ?>" class="w-35 h-35 object-cover mb-4 rounded-full  shadow">
                <h3 class="text-lg font-semibold mb-1"><?php echo htmlspecialchars($username); ?></h3>
                <div class="flex justify-center items-center mb-1">
                <?php
                    $rating = (int) $review['Rating'];
                    for ($i = 1; $i <= $rating; $i++) {
                        echo '<span style="color:gold;font-size:1.8em;">&#9733;</span>';
                    }
                ?>
                </div>
                <p class="text-sm text-center leading-[2] mt-1"><?php echo htmlspecialchars($review['Description']); ?></p>
            </div>
            <?php endforeach; ?>
<?php else: ?>
            <p class="flex justify-center align-middle text-center text-red-500 text-lg">No review found.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
