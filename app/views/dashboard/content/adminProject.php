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
    <div class="flex flex-wrap gap-4 mb-6 justify-center align-middle">
        <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('pending')">
            <img src="/DreamAbode/public/images/Status.png" class="w-7 h-7 mr-2" alt="Pending">Pending
        </button>
        <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('accept')">
            <img src="/DreamAbode/public/images/Accept.png" class="w-6 h-6 mr-2" alt="Accepted">Accepted
        </button>
        <button class="flex items-center justify-center bg-[#5CFFAB] hover:bg-[#32e38d] text-black font-semibold py-2 px-3 rounded-md w-[130px] transition-colors duration-200" onclick="showSection('reject')">
            <img src="/DreamAbode/public/images/Reject.png" class="w-6 h-6 mr-2" alt="Rejected">Rejected
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

    <section id="project-container-pending" class="flex flex-wrap gap-10 justify-center p-4 h-[475px] overflow-y-auto custom-scrollbar">
        <?php if (! empty($pendingProjects) && is_array($pendingProjects)): ?>
        <?php foreach ($pendingProjects as $prop): ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
            <!-- project image  -->
            <div class="relative">
                <?php if (! empty($prop['ImageData'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($prop['ImageData']) ?>" alt="Project Image" class="w-full h-60 object-cover">
                <?php endif; ?>
            </div>

            <!-- project data  -->
            <div class="p-4 bg-[#5CFFAB] text-black text-center">
                <h2 class="text-xl font-bold m-1"><?php echo htmlspecialchars($prop['ProjectName']) ?></h2>
                <div class="flex justify-center items-center space-x-2 my-4">
                    <img src="./images/Location.png" alt="Location" class="h-7 w-5.5">
                    <span><?php echo htmlspecialchars($prop['Location']) ?></span>
                </div>

                <div class="flex justify-center items-center mt-2 space-x-8">
                    <div class="flex items-center space-x-2">
                        <img src="./images/money.png" alt="Price" class="h-7 w-7 mr-2">
                        <span>RS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo htmlspecialchars($prop['Price']) ?> M</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <img src="./images/Accept.png" alt="CompletionDate" class="h-6 w-6 mr-2">
                        <span><?php echo htmlspecialchars($prop['CompletionDate']) ?> </span>
                    </div>
                </div>

                <!-- Accept/Reject form -->
                <?php if ($prop['Status'] === 'Pending'): ?>
                    <form action="./adminProfile/handleProjectRequest" method="POST" class="mt-4 space-x-2">
                        <input type="hidden" name="project_id" value="<?php echo $prop['ProjectID'] ?>">
                        <button type="submit" name="action" value="Accept" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-[100px] transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">Accept</button>
                        <button type="submit" name="action" value="Reject" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-[100px] transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">Reject</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="flex justify-center align-middle text-center text-red-500 text-lg">No properties found.</p>
        <?php endif; ?>
    </section>

    <section id="project-container-accept" class="flex flex-wrap gap-10 justify-center p-4 h-[475px] overflow-y-auto custom-scrollbar">
        <?php if (! empty($acceptedProjects) && is_array($acceptedProjects)): ?>
        <?php foreach ($acceptedProjects as $prop): ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
            <!-- project image -->
            <div class="relative group">
                <?php if (! empty($prop['ImageData'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($prop['ImageData']) ?>" alt="Project Image" class="w-full h-60 object-cover">
                <?php endif; ?>

                <!-- Hoverable icon with tooltip inside the group -->
                <div class="absolute top-2 right-2">
                    <div class="bg-white rounded-full p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                        <img src="./images/Assign.png" alt="Assign" class="h-8 w-8">
                    </div>

                    <div class="hidden group-hover:block absolute top-3 right-3 bg-white text-black font-semibold text-xs px-2 py-1 rounded z-50">
                        <?php echo htmlspecialchars($prop['AgentID']) ?>
                    </div>
                </div>
            </div>


            <!-- project data  -->
            <div class="p-4 bg-[#5CFFAB] text-black text-center">
                <h2 class="text-xl font-bold m-1"><?php echo htmlspecialchars($prop['ProjectName']) ?></h2>
                <div class="flex justify-center items-center space-x-2 my-4">
                    <img src="./images/Location.png" alt="Location" class="h-7 w-5.5">
                    <span>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo htmlspecialchars($prop['Location']) ?> </span>
                </div>

                <div class="flex justify-center items-center mt-2 space-x-8">
                    <div class="flex items-center space-x-2">
                        <img src="./images/money.png" alt="Price" class="h-7 w-7 mr-2">
                        <span>RS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo htmlspecialchars($prop['Price']) ?> M</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <img src="./images/Accept.png" alt="CompletionDate" class="h-6 w-6 mr-2">
                        <span><?php echo htmlspecialchars($prop['CompletionDate']) ?> </span>
                    </div>
                </div>

                <!-- buttons -->
                <?php if ($prop['Status'] === 'Accept'): ?>
                    <form action="./adminProfile/deleteProject" method="POST" class="mt-4 space-x-2">
                        <input type="hidden" name="project_id" value="<?php echo $prop['ProjectID'] ?>">
                        <button type="submit" name="action" value="Remove" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-[100px] transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">Remove</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="flex justify-center align-middle text-center text-red-500 text-lg">No properties found.</p>
        <?php endif; ?>
    </section>

    <section id="project-container-reject" class="flex flex-wrap gap-10 justify-center p-4 h-[475px] overflow-y-auto custom-scrollbar">
        <?php if (! empty($rejectedProjects) && is_array($rejectedProjects)): ?>
        <?php foreach ($rejectedProjects as $prop): ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
            <!-- project image  -->
            <div class="relative">
                <?php if (! empty($prop['ImageData'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($prop['ImageData']) ?>" alt="Project Image" class="w-full h-60 object-cover">
                <?php endif; ?>
            </div>

            <!-- project data  -->
            <div class="p-4 bg-[#5CFFAB] text-black text-center">
                <h2 class="text-xl font-bold m-1"><?php echo htmlspecialchars($prop['ProjectName']) ?></h2>
                <div class="flex justify-center items-center space-x-2 my-4">
                    <img src="./images/Location.png" alt="Location" class="h-7 w-5.5">
                    <span>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo htmlspecialchars($prop['Location']) ?> </span>
                </div>

                <div class="flex justify-center items-center mt-2 space-x-8">
                    <div class="flex items-center space-x-2">
                        <img src="./images/money.png" alt="Price" class="h-7 w-7 mr-2">
                        <span>RS                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo htmlspecialchars($prop['Price']) ?> M</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <img src="./images/Accept.png" alt="CompletionDate" class="h-6 w-6 mr-2">
                        <span><?php echo htmlspecialchars($prop['CompletionDate']) ?> </span>
                    </div>
                </div>

                <!-- buttons -->
                <?php if ($prop['Status'] === 'Reject'): ?>
                    <form action="./adminProfile/deleteProject" method="POST" class="mt-4 space-x-2">
                        <input type="hidden" name="project_id" value="<?php echo $prop['ProjectID'] ?>">
                        <button type="submit" name="action" value="Remove" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-[100px] transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">Remove</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="flex justify-center align-middle text-center text-red-500 text-lg">No properties found.</p>
        <?php endif; ?>
    </section>

    <script>
        function showSection(section) {
            const sections = ['pending', 'accept', 'reject'];

            sections.forEach(sec => {
                const container = document.getElementById(`project-container-${sec}`);
                if (sec === section) {
                    container.style.display = 'flex';
                } else {
                    container.style.display = 'none';
                }
            });
        }

        window.onload = function() {
            showSection('pending');
        };

    </script>

</body>
</html>