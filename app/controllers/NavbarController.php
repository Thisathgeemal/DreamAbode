<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$uri         = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$currentPage = $uri ?: 'home';

$navItems = [
    'home'     => 'Home',
    'sales'    => 'Sales',
    'rentals'  => 'Rentals',
    'projects' => 'Projects',
    'loans'    => 'Loans',
    'about'    => 'About',
];

$profileLink = './login';
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'member':$profileLink = './memberProfile';
            break;
        case 'admin':$profileLink = './adminProfile';
            break;
        case 'agent':$profileLink = './agentProfile';
            break;
    }
}

function isActive($page, $currentPage)
{
    return ($page === $currentPage) ? 'border-b-4 border-[#5CFFAB]' : '';
}
