<?php

require_once '../routes/route.php';

// define the controller and method from the route
$controllerName = ucfirst($route['controller']) . 'Controller';
$method         = $route['method'];

$controllerFile = '../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Method '$method' not found in controller '$controllerName'";
    }
} else {
    echo "Controller '$controllerName' not found";
}
