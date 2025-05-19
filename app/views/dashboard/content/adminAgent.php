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

    <!-- Top Button Groups -->
    <div class="flex flex-wrap gap-4 mb-6">
        <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('view')">
            <img src="/DreamAbode/public/images/View.gif" class="w-7 h-7 mr-2" alt="Pending">View
        </button>
        <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('add')">
            <img src="/DreamAbode/public/images/AddIcon.png" class="w-7 h-7 mr-2" alt="Accepted">Add
        </button>
                <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200">
            <img src="/DreamAbode/public/images/Reject.png" class="w-6 h-6 mr-2" alt="Accepted">Remove
        </button>
    </div>

    <?php if ($message): ?>
<?php
    $colorClass = (strpos(strtolower($message), 'success') !== false)
    ? 'text-green-600'
    : 'text-red-600';
    echo "<div class=\"mb-4 text-center font-semibold p-1 " . htmlspecialchars($colorClass) . "\">";
    echo htmlspecialchars($message);
    echo "</div>";
?>
<?php endif; ?>

        <section id="property-container-view" >

        </section>

        <section id="property-container-add" >

        </section>

    <script>
        function showSection(section) {
            const sections = ['view', 'add'];

            sections.forEach(sec => {
                const container = document.getElementById(`property-container-${sec}`);
                if (sec === section) {
                    container.style.display = 'flex';
                } else {
                    container.style.display = 'none';
                }
            });
        }

        window.onload = function() {
            showSection('view');
        };
    </script>

</body>
</html>