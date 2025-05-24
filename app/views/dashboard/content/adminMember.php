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

        <section class="md:p-6 w-full">
            <h1 class="flex justify-center text-center align-miiddle text-4xl font-bold poppins p-4 mb-4 mt-2">Member Details</h1>
            <!-- Top Button Groups -->
            <div class="flex flex-wrap gap-4 mb-6 align-middle justify-center">
                <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200">
                    <img src="/DreamAbode/public/images/View.gif" class="w-7 h-7 mr-2" alt="View">View
                </button>
                <button type="submit" name="delete_selected"  form="deleteForm" class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200"  onclick="return confirm('Are you sure you want to delete selected agents?');">
                    <img src="/DreamAbode/public/images/Reject.png" class="w-6 h-6 mr-2" alt="Remove">Remove
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

            <form id="deleteForm" method="POST" action="./memberProfile/deleteMember">
                <section class="p-4 flex justify-center align-middle">
                    <div class="-full max-w-7xl border border-green-300 shadow-lg rounded-lg overflow-hidden">
                        <div class="max-h-[450px] overflow-y-auto custom-scrollbar">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
                                <thead class="bg-green-200 text-gray-800 sticky top-0 z-10">
                                    <tr>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Select</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Username</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Email</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Mobile</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">DOB</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Gender</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Plan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                                    <?php if (! empty($viewMembers)): ?>
<?php foreach ($viewMembers as $member): ?>
                                            <tr class="hover:bg-green-100 even:bg-gray-50 transition">
                                                <td class="py-2 px-6">
                                                    <?php $id = htmlspecialchars($member['ID']); ?>
                                                    <input type="checkbox" name="member_ids[]" value="<?php echo $id; ?>" class="h-4 w-4 text-green-500" />
                                                </td>
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($member['Username']) ?></td>
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($member['Email']) ?></td>
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($member['MobileNumber']) ?></td>
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($member['DOB']) ?></td>
                                                <td class="py-2 px-4"><?php echo htmlspecialchars($member['Gender']) ?></td>
                                                <td class="py-2 px-4 font-medium text-green-600"><?php echo htmlspecialchars($member['Plan']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
<?php else: ?>
                                        <tr><td colspan="7" class="px-6 py-4 text-center text-red-500 font-semibold">No members found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </form>
        </section>

</body>
</html>