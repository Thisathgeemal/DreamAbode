<x-guest-layout>
    <!-- hero section 1 -->
    <section class="relative h-[550px] flex flex-col md:flex-row items-center mt-6">
        <!-- Text Section -->
        <div
            class="flex flex-col justify-center w-full md:w-[45%] pl-4 md:pl-[7%] h-auto md:h-full mt-10 md:mt-0 order-2 md:order-1 relative">
            <h1 class="text-[7vw] md:text-[3.5vw] font-bold text-black leading-[1.15] poppins text-center md:text-left">
                Your Trusted <br> Partner in Real <br> Estate
            </h1>
            <h2
                class="mt-4 md:mt-[6%] text-[4vw] md:text-[1.6vw] font-normal text-black poppins text-center md:text-left">
                We’re your trusted partner in finding the <br class="hidden md:block"> perfect property with integrity,
                innovation, <br class="hidden md:block"> and personalized service.
            </h2>

            <!-- Mobile & Desktop: "Discover Our Story" Button -->
            <div
                class="mt-6 md:mt-[6%] w-[50%] md:w-[38%] h-[40px] md:h-[9.5%] bg-[#5CFFAB] rounded-[2vw] md:rounded-[0.7vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] shadow-md hover:shadow-lg cursor-pointer mx-auto md:mx-0 flex items-center justify-center">
                <span
                    class="text-[4vw] md:text-[1.4vw] text-black font-normal poppins text-center transition-colors duration-300">
                    Discover Our Story
                </span>
            </div>
        </div>

        <!-- Image & Review Button Section -->
        <div
            class="flex flex-col justify-center items-center md:items-end relative w-full md:w-[55%] h-[250px] md:h-full pr-0 order-1 md:order-2 mt-6 md:mt-0">
            <!-- background image -->
            <div class="flex items-center justify-center w-full h-full">
                <img src="./images/AboutOneBg.png" alt="About Bg"
                    class="w-[90vw] h-[250px] md:w-[90%] md:h-[95%] object-contain">
            </div>

            <!-- Mobile: Small floating review button -->
            <a href="{{ route('member.property.postAd') }}"
                class="absolute bottom-[-35px] right-4 md:hidden flex items-center justify-center z-50">
                <div
                    class="w-12 h-12 bg-[#5CFFAB] border border-black rounded-full flex items-center justify-center transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
                    <img src="./images/ReviewButton.png" alt="Review" class="w-10 h-10 object-contain">
                </div>
            </a>

            <!-- Desktop: Full review button -->
            <a href="{{ route('member.property.postAd') }}"
                class="hidden md:flex absolute md:bottom-[-1%] md:right-[18%] w-[16%] h-[7.5%] items-center justify-end z-50">
                <div
                    class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative flex items-center">
                    <div
                        class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full flex items-center justify-center">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[24%] left-[35%] text-[0.9vw] text-black font-medium">Post Your
                        Ad</span>
                </div>
            </a>
        </div>
    </section>

    <!-- hero section 2 -->
    <section class="relative mt-16 md:mt-8 flex flex-col items-center p-4 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-4 w-full max-w-7xl items-center">

            <!-- Left Grid: Logo/Icon -->
            <div
                class="flex justify-center items-center h-[350px] w-full rounded-2xl shadow-[0_0_15px_4px_rgba(92,255,171,0.4)] transition-transform duration-500 ease-in-out hover:scale-105 hover:shadow-[0_0_15px_4px_rgba(92,255,171,0.4)] cursor-pointer">
                <img src="./images/AboutTwoBg.png" alt="About Bg" class="w-[350px] h-[350px] rounded-2xl object-cover">
            </div>

            <!-- Middle Grid: Union Icon -->
            <div class="flex justify-center items-center h-[100px] md:w-[200px] md:h-[350px]">
                <img src="./images/Union.png" alt="Union Bg"
                    class="h-[350px] w-[45px] md:rotate-0 rotate-90 transition-transform duration-300">
            </div>

            <!-- Right Grid: Description -->
            <div
                class="flex flex-col justify-center items-center md:items-start text-center md:text-left space-y-4 rounded-2xl shadow-[0_0_15px_4px_rgba(92,255,171,0.4)] transition-transform duration-500 ease-in-out hover:scale-105 hover:shadow-[0_0_15px_4px_rgba(92,255,171,0.4)] cursor-pointer w-full h-[350px] p-6">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight poppins">
                    Explore Dream Abode
                </h1>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed poppins text-justify">
                    Welcome to <span class="font-semibold text-green-600">Dream Abode</span>, where living meets luxury.
                    We craft exceptional spaces that blend style, comfort, and elegance whether it’s a sleek apartment
                    or a grand villa. At Dream Abode, we don’t just build homes; we create living experiences that feel
                    like a dream every single day.
                </p>
            </div>

        </div>
    </section>

    <!-- Hero Section 3 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-16 px-4 sm:px-6 lg:px-12">

        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 font-poppins leading-tight">
                Get in Touch with Dream Abode
            </h1>
            <p class="mt-4 text-base sm:text-lg lg:text-xl text-gray-700 font-poppins leading-relaxed">
                Your dream home is just a conversation away! Whether you're looking for your perfect property, need
                expert real estate advice, or have inquiries about our services, we're here to help. Reach out to us,
                and let’s turn your vision into reality.
            </p>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-col md:flex-row flex-wrap justify-center items-center gap-8 w-full">

            <!-- Card Item: Colombo -->
            <div
                class="flex-1 max-w-md w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition-transform duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer">
                <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-gray-900">Dream Abode Real Estate <br> Colombo
                </h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1978.7698578454135!2d80.63755512941708!3d7.29309175401359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae3662c3b88e9ff%3A0x5b092bc39f5d4ed2!2sSri%20Dalada%20Veediya%2C%20Kandy!5e0!3m2!1sen!2slk!4v1747755707738!5m2!1sen!2slk"
                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" class="rounded-lg w-full h-[250px] shadow-inner">
                </iframe>
                <div class="flex flex-col justify-center items-center mt-6 text-gray-900 space-y-1">
                    <p class="font-medium">+94 11 234 5678</p>
                    <p class="font-medium">info@dreamabode.lk</p>
                    <p class="font-medium">123 Luxury Lane, Colombo, Sri Lanka</p>
                </div>
            </div>

            <!-- Card Item: Kandy -->
            <div
                class="flex-1 max-w-md w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition-transform duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer">
                <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-gray-900">Dream Abode Real Estate <br> Kandy</h3>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.0535652958915!2d79.96023731076652!3d7.002975217376222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2f861c6d50e2d%3A0x1347c9fc1104a454!2sKadawatha%20Interchange!5e0!3m2!1sen!2slk!4v1747755781451!5m2!1sen!2slk"
                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" class="rounded-lg w-full h-[250px] shadow-inner">
                </iframe>
                <div class="flex flex-col justify-center items-center mt-6 text-gray-900 space-y-1">
                    <p class="font-medium">+94 11 234 9856</p>
                    <p class="font-medium">kandy@dreamabode.lk</p>
                    <p class="font-medium">456 Heritage Street, Kandy, Sri Lanka</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Hero Section 4 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-16 px-4 sm:px-6 lg:px-12">

        <!-- Heading Section -->
        <div class="w-full max-w-6xl mx-auto">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-gray-900 poppins">
                Our Journey So Far
            </h1>
            <p
                class="text-base sm:text-lg lg:text-xl text-gray-700 poppins mt-6 sm:mt-8 leading-relaxed text-justify sm:text-center px-2 sm:px-5">
                Dream Abode has grown into a trusted name in real estate, delivering quality homes and earning industry
                recognition.
                With successful projects and happy homeowners, we take pride in every milestone along the way.
            </p>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-col md:flex-row flex-wrap justify-center items-stretch gap-6">

            <!-- Card Item: 2024 -->
            <div
                class="flex-1 max-w-sm w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer">
                <img src="./images/Award2024.png" alt="Top Innovator in Modern Architecture"
                    class="w-32 h-32 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-1">2024</h3>
                <h3 class="text-lg font-semibold mb-2">Top Innovator in Modern Architecture</h3>
                <p class="text-sm text-gray-700 leading-relaxed text-center">
                    We were proud to receive this prestigious award at the National Real Estate Awards, marking a
                    significant milestone in our pursuit of excellence.
                </p>
            </div>

            <!-- Card Item: 2023 -->
            <div
                class="flex-1 max-w-sm w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer">
                <img src="./images/Award2023.png" alt="Excellence in Sustainable Development"
                    class="w-32 h-32 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-1">2023</h3>
                <h3 class="text-lg font-semibold mb-2">Excellence in Sustainable Development</h3>
                <p class="text-sm text-gray-700 leading-relaxed text-center">
                    We won the Global Real Estate Sustainability Award for building eco-friendly, energy-efficient
                    homes, supporting a greener future.
                </p>
            </div>

            <!-- Card Item: 2022 -->
            <div
                class="flex-1 max-w-sm w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer">
                <img src="./images/Award2022.png" alt="Best Luxury Developer of the Year"
                    class="w-32 h-32 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-1">2022</h3>
                <h3 class="text-lg font-semibold mb-2">Best Luxury Developer of the Year</h3>
                <p class="text-sm text-gray-700 leading-relaxed text-center">
                    We were honored with this prestigious award at the National Real Estate Awards, marking a major
                    achievement in our journey toward excellence.
                </p>
            </div>
        </div>
    </section>

    @auth
        <!-- Hero Section 5 -->
        <section class="relative flex flex-col justify-center items-center text-center mt-16 px-4 sm:px-6 lg:px-12">

            <!-- Heading Section -->
            <div class="w-full max-w-6xl mx-auto">
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-gray-900 poppins">
                    Our Happy Homeowners
                </h1>
                <p
                    class="text-base sm:text-lg lg:text-xl text-gray-700 poppins mt-6 sm:mt-8 leading-relaxed text-justify sm:text-center px-2 sm:px-5">
                    Every home has a story, and our clients are the heart of ours. At Dream Abode, we don’t just build
                    houses. We create experiences, lasting relationships, and dream worthy spaces. Hear from our happy
                    homeowners who have made their dream a reality with us.
                </p>
            </div>

            <!-- Cards Section -->
            <div class="mt-12 flex flex-col md:flex-row flex-wrap justify-center items-stretch gap-6">
                <div id="member-reviews"
                    class="flex flex-col md:flex-row flex-wrap justify-center items-stretch gap-6 w-full">
                    <!-- Cards will be injected here dynamically -->
                </div>
            </div>
        </section>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    fetchMemberReviews();
                });

                async function fetchMemberReviews() {
                    const container = document.getElementById('member-reviews');
                    container.innerHTML = `
                    <p class="flex justify-center items-center text-center text-gray-500 text-lg">
                        Loading reviews, please wait...
                    </p>`;
                    try {
                        const response = await axios.get('/api/reviews', {
                            headers: {
                                Authorization: `Bearer {{ session('auth_token') }}`
                            }
                        });
                        renderReviews(container, response.data.visible_reviews);
                    } catch (error) {
                        console.error('Error fetching reviews:', error);
                        showError('Failed to fetch your reviews. Please try again.');
                    }
                }

                function renderReviews(container, reviews) {
                    container.innerHTML = '';
                    if (!reviews || reviews.length === 0) {
                        container.innerHTML = `
                        <p class="flex justify-center items-center text-center text-green-500 text-lg">
                            You haven’t added any reviews yet.
                        </p>`;
                        return;
                    }
                    reviews.forEach(review => container.appendChild(createReviewCard(review)));
                }

                function createReviewCard(review) {
                    const card = document.createElement('div');
                    card.className =
                        'flex-1 max-w-sm w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer';

                    // Profile image or initial
                    card.appendChild(createProfileImage(review.member));

                    // Username
                    const name = document.createElement('h3');
                    name.className = 'text-lg font-semibold mb-1';
                    name.textContent = review.member?.name || 'Anonymous';
                    card.appendChild(name);

                    // Rating stars
                    card.appendChild(createRatingStars(review.rating));

                    // Description
                    const desc = document.createElement('p');
                    desc.className = 'text-sm text-gray-700 leading-relaxed';
                    desc.textContent = review.description || '';
                    card.appendChild(desc);

                    return card;
                }

                function createProfileImage(member) {
                    if (member && member.profile_photo_path) {
                        const img = document.createElement('img');
                        img.src = `/storage/${member.profile_photo_path}`;
                        img.alt = member.name ? `${member.name}'s Review` : 'User Review';
                        img.className = 'w-[88px] h-[88px] object-cover m-6 rounded-full shadow-md';
                        return img;
                    } else {
                        const initial = (member?.name || 'U')[0].toUpperCase();
                        const div = document.createElement('div');
                        div.textContent = initial;
                        div.className =
                            'w-[88px] h-[88px] flex items-center justify-center mx-6 mb-6 mt-2 rounded-full shadow-md bg-gray-400 text-white text-2xl font-bold';
                        return div;
                    }
                }

                function createRatingStars(rating) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'flex justify-center items-center mb-2';
                    for (let i = 1; i <= (rating || 0); i++) {
                        wrapper.innerHTML += '<span class="text-yellow-500 text-xl">&#9733;</span>';
                    }
                    return wrapper;
                }
            </script>
        @endpush
    @endauth

</x-guest-layout>
