<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
unset($_SESSION['msg']);

echo "<h2 class='text-2xl font-semibold'>Dashboard</h2>";
echo "<p>Here are your Dashboard.</p>";

if ($message) {
    echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' role='alert'>";
    echo "<span class='block sm:inline'>$message</span>";
    echo "</div>";
}

echo "<div class='mt-4'>";
