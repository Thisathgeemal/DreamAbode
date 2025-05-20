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

        <section class="p-10 w-full">
            <h1 class="flex justify-center items-center text-4xl font-bold poppins p-4 mb-4 mt-2">Member Message</h1>
            <!-- Top Button Groups -->
            <div class="flex flex-wrap gap-4 mb-6 align-middle justify-center">
                <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('Call')">
                    <img src="/DreamAbode/public/images/Call.png" class="w-7 h-7 mr-2" alt="Call">Call
                </button>
                <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('Email')">
                    <img src="/DreamAbode/public/images/Email.png" class="w-7 h-7 mr-2" alt="Email">Email
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

            <section id="memberCall" class="p-4 flex justify-center align-middle">
                <div class="w-full max-w-7xl border border-green-300 shadow-lg rounded-lg overflow-hidden">
                    <div class="max-h-[450px] overflow-y-auto custom-scrollbar">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
                            <thead class="bg-green-200 text-gray-800">
                                <tr>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Id</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Name</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">MobileNumber</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Message</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">PropertyID</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                                <?php if (! empty($viewMessageCall)): ?>
<?php foreach ($viewMessageCall as $message): ?>
                                        <tr class="hover:bg-green-100 even:bg-gray-50 transition">
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['MessageID']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['Name']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['MobileNumber']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['Message']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['PropertyID']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
<?php else: ?>
                                    <tr><td colspan="7" class="px-6 py-4 text-center text-red-500">No message found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="memberEmail" class="p-4 flex justify-center align-middle">
                <div class="w-full max-w-7xl border border-green-300 shadow-lg rounded-lg overflow-hidden">
                    <div class="max-h-[450px] overflow-y-auto custom-scrollbar">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
                            <thead class="bg-green-200 text-gray-800">
                                <tr>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Id</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Name</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Email</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">Message</th>
                                    <th class="py-2 px-6 text-left text-sm font-semibold">PropertyID</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                                <?php if (! empty($viewMessageEmail)): ?>
<?php foreach ($viewMessageEmail as $message): ?>
                                        <tr class="hover:bg-green-100 even:bg-gray-50 transition">
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['MessageID']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['Name']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['Email']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['Message']) ?></td>
                                            <td class="py-2 px-6"><?php echo htmlspecialchars($message['PropertyID']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
<?php else: ?>
                                    <tr><td colspan="5" class="px-6 py-4 text-center text-red-500">No message found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </section>

    <script>
        function showSection(section) {
            const sections = ['Call', 'Email'];

            sections.forEach(sec => {
                const container = document.getElementById(`member${sec}`);
                if (sec === section) {
                    container.style.display = 'flex';
                } else {
                    container.style.display = 'none';
                }
            });
        }

        window.onload = function() {
            showSection('Call');
        };
    </script>

</body>
</html>