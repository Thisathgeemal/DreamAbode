<?php
    session_start();
    define('BASE_URL', '/DreamAbode');

    $message = isset($_SESSION['msg']) ? $_SESSION['msg'] : (isset($_SESSION['error']) ? $_SESSION['error'] : '');
    unset($_SESSION['msg']);
    unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="<?php echo BASE_URL . '/public/css/styles.css'; ?>" rel="stylesheet">
</head>
<body>

    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <section class="bg-white flex items-center justify-center px-4 pt-8 pb-5">
        <div class="bg-white p-8 rounded-xl max-w-lg w-full shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <form method="POST" action="<?php echo BASE_URL . '/public/review/addReview'; ?>">
                <h2 class="text-4xl font-bold mb-8 text-center poppins">Share your experience</h2>

                <?php if ($message): ?>
<?php
    $colorClass = (strpos(strtolower($message), 'success') !== false) ? 'text-green-600' : 'text-red-600';
    echo "<div class=\"mb-4 text-center font-semibold p-1 " . htmlspecialchars($colorClass) . "\">";
    echo htmlspecialchars($message);
    echo "</div>";
?>
<?php endif; ?>

                <div class="mb-5 poppins">
                    <label for="message" class="block text-lg font-medium text-gray-700">Your Message</label>
                    <textarea id="message" name="message" rows="4" placeholder="Describe your experience..." class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400" required></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-lg font-medium text-gray-700 mb-2">Rate Us</label>
                    <div id="starRating" class="flex space-x-3 text-[#d1d5db] text-4xl cursor-pointer">
                        <span data-value="1">★</span>
                        <span data-value="2">★</span>
                        <span data-value="3">★</span>
                        <span data-value="4">★</span>
                        <span data-value="5">★</span>
                    </div>
                    <noscript>
                        <select name="rating" required>
                            <option value="">Select a rating</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </noscript>
                    <input type="hidden" name="rating" id="ratingValue" value="1" required>
                </div>
                <div class="my-2 flex justify-center">
                    <button type="submit" class="w-[200px] bg-green-400 hover:bg-green-200 text-black font-semibold py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </section>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>

    <script>
        const stars = document.querySelectorAll('#starRating span');
        const ratingInput = document.getElementById('ratingValue');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                ratingInput.value = index + 1;
                stars.forEach((s, i) => {
                    s.style.color = i <= index ? '#facc15' : '#d1d5db';
                });
            });
        });

        document.querySelector('form').addEventListener('submit', (e) => {
            if (!ratingInput.value) {
                e.preventDefault();
                alert('Please select a rating.');
            }
        });
    </script>

</body>
</html>
<?php ob_end_flush(); ?>