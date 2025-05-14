<?php

$currentPage = basename($_SERVER['PHP_SELF']);

$request = $_SERVER['REQUEST_URI'];

// remove query string and public path
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$request    = str_replace($scriptName, '', $request);
$request    = strtok($request, '?');

$segments = explode('/', trim($request, '/'));

$controller = ! empty($segments[0]) ? $segments[0] : 'home';
$method     = ! empty($segments[1]) ? $segments[1] : 'index';

$route = [
    'controller' => $controller,
    'method'     => $method,
];
