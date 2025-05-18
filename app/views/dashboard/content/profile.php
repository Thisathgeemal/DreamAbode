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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <section class="p-10 w-full">
        <form method="POST" action="./memberProfile/updateProfile" enctype="multipart/form-data" class="w-full max-w-3xl mx-auto">

            <!-- Profile Image -->
            <div class="flex flex-col items-center mb-8">
                <div class="relative w-36 h-36">
                    <img src="<?php echo htmlspecialchars($userData['Image']); ?>" alt="Profile"
                        class="w-full h-full rounded-full object-cover border-2 border-gray-500 shadow-sm">

                    <label for="Image"
                        class="absolute bottom-5 -right-2 bg-white p-1 rounded-full border shadow cursor-pointer">
                        <img src="/DreamAbode/public/images/AddImage.png" alt="Add Image" class="w-6 h-6">
                    </label>

                    <input type="file" name="Image" id="Image" class="hidden">
                </div>
            </div>

            <?php if ($message): ?>
<?php
    $colorClass = (strpos(strtolower($message), 'success') !== false)
    ? 'text-green-600'
    : 'text-red-600';
?>
                <div class="mb-4 text-center font-semibold p-1 <?php echo htmlspecialchars($colorClass)?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Input Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="username" class="block text-md font-medium text-black">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username"
                        <?php echo isset($userData['Username']) ? 'value="' . htmlspecialchars($userData['Username']) . '"' : ''; ?>
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label for="password" class="block text-md font-medium text-black">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label for="email" class="block text-md font-medium text-black">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        <?php echo isset($userData['Email']) ? 'value="' . htmlspecialchars($userData['Email']) . '"' : ''; ?>
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label for="dob" class="block text-md font-medium text-black">Date of Birth</label>
                    <input type="text" id="dob" name="dob" placeholder="YYYY-MM-DD"
                        <?php echo isset($userData['DOB']) ? 'value="' . htmlspecialchars($userData['DOB']) . '"' : ''; ?>
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label for="mobile" class="block text-md font-medium text-black">Mobile Number</label>
                    <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number"
                        <?php echo isset($userData['MobileNumber']) ? 'value="' . htmlspecialchars($userData['MobileNumber']) . '"' : ''; ?>
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label for="gender" class="block text-md font-medium text-black">Gender</label>
                    <select id="gender" name="gender"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-3 text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                        <option value="">Select Gender</option>
                        <option value="Male"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php echo(isset($userData['Gender']) && $userData['Gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php echo(isset($userData['Gender']) && $userData['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option><?php echo($userData['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
            </div>

            <!-- Update Button -->
            <div class="mt-6 flex justify-center">
                <button type="submit"
                    class="bg-[#5CFFAB] text-black font-medium px-8 py-2 rounded-md hover:bg-[#32e38d] transition duration-200">
                    Update
                </button>
            </div>
        </form>
    </section>


</body>
</html>