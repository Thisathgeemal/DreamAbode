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

    <section class="bg-white flex items-center justify-center px-4 pt-8 pb-5">
        <div class="bg-white p-8 rounded-xl max-w-md w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <form method="POST">
                <h2 class="text-4xl font-bold mb-8 text-center poppins">Share your experience</h2>

                <!-- Message Field -->
                <div class="mb-5 poppins">
                    <label for="message" class="block text-lg font-medium text-gray-700">Your Message</label>
                    <textarea id="message" name="message" rows="4" placeholder="Describe your experience..." class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required></textarea>
                </div>

                <!-- Rating Field -->
                <div class="mb-6">
                    <label class="block text-lg font-medium text-gray-700 mb-2">Rate Us</label>
                    <div id="starRating" class="flex space-x-3 text-yellow-400 text-4xl cursor-pointer">
                    <span data-value="1">★</span>
                    <span data-value="2">★</span>
                    <span data-value="3">★</span>
                    <span data-value="4">★</span>
                    <span data-value="5">★</span>
                    </div>
                    <input type="hidden" name="rating" id="ratingValue" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-green-400 hover:bg-green-200 text-black font-semibold py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">
                    Submit Review
                </button>
            </form>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

    <script>
        const stars = document.querySelectorAll('#starRating span');
        const ratingValue = document.getElementById('ratingValue');
        let selected = 0;

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
            const val = parseInt(star.getAttribute('data-value'));
            highlightStars(val);
            });

            star.addEventListener('mouseout', () => {
            highlightStars(selected);
            });

            star.addEventListener('click', () => {
            selected = parseInt(star.getAttribute('data-value'));
            ratingValue.value = selected;
            highlightStars(selected);
            });
        });

        function highlightStars(value) {
            stars.forEach(star => {
            const starVal = parseInt(star.getAttribute('data-value'));
            star.style.color = starVal <= value ? '#facc15' : '#d1d5db'; // yellow-400 or gray-300
            });
        }
    </script>

</body>
</html>
