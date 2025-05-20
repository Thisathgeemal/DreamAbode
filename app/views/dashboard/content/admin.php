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
            <h1 class="flex justify-center align-miiddle text-4xl font-bold poppins p-4 mb-4 mt-2">Admin Details</h1>
            <!-- Top Button Groups -->
            <div class="flex flex-wrap gap-4 mb-6 align-middle justify-center">
                <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('view')">
                    <img src="/DreamAbode/public/images/View.gif" class="w-7 h-7 mr-2" alt="View">View
                </button>
                <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('add')">
                    <img src="/DreamAbode/public/images/AddIcon.png" class="w-7 h-7 mr-2" alt="Add">Add
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

            <form id="deleteForm" method="POST" action="./adminProfile/deleteAdmin">
                <section id="property-container-view" class="p-4 flex justify-center align-middle">
                    <div class="-full max-w-7xl border border-green-300 shadow-lg rounded-lg overflow-hidden">
                        <div class="max-h-[450px] overflow-y-auto custom-scrollbar">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white rounded-lg">
                                <thead class="bg-green-200 text-gray-800">
                                    <tr>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Select</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Username</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Email</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Mobile</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">DOB</th>
                                        <th class="py-2 px-6 text-left text-sm font-semibold">Gender</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                                    <?php if (! empty($viewAdmins)): ?>
<?php foreach ($viewAdmins as $admin): ?>
                                            <tr class="hover:bg-green-100 even:bg-gray-50 transition">
                                                <td class="py-2 px-6">
                                                    <?php $id = htmlspecialchars($admin['ID']); ?>
                                                    <input type="checkbox" name="admin_ids[]" value="<?php echo $id; ?>" class="h-4 w-4 text-green-500" />
                                                </td>
                                                <td class="py-2 px-6"><?php echo htmlspecialchars($admin['Username']) ?></td>
                                                <td class="py-2 px-6"><?php echo htmlspecialchars($admin['Email']) ?></td>
                                                <td class="py-2 px-6"><?php echo htmlspecialchars($admin['MobileNumber']) ?></td>
                                                <td class="py-2 px-6"><?php echo htmlspecialchars($admin['DOB']) ?></td>
                                                <td class="py-2 px-6"><?php echo htmlspecialchars($admin['Gender']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
<?php else: ?>
                                        <tr><td colspan="7" class="px-6 py-4 text-center text-red-500">No admins found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </form>

            <section id="property-container-add" class="mt-8">
                <form method="POST" action="./adminProfile/createadmin" enctype="multipart/form-data" class="w-full max-w-3xl mx-auto" id="property-container-add">
                    <!-- Input Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="username" class="block text-md font-medium text-black">Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter your username"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        </div>

                        <div>
                            <label for="password" class="block text-md font-medium text-black">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        </div>

                        <div>
                            <label for="email" class="block text-md font-medium text-black">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        </div>

                        <div>
                            <label for="dob" class="block text-md font-medium text-black">Date of Birth</label>
                            <input type="date" id="dob" name="dob" placeholder="YYYY-MM-DD"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <div>
                            <label for="mobile" class="block text-md font-medium text-black">Mobile Number</label>
                            <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        </div>

                        <div>
                            <label for="gender" class="block text-md font-medium text-black">Gender</label>
                            <select id="gender" name="gender"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-center">
                        <button type="submit"
                            class="bg-[#5CFFAB] text-black font-medium px-8 py-2 rounded-md hover:bg-[#32e38d] transition duration-200 w-[115px]">
                            Add
                        </button>
                    </div>
                </form>
            </section>

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