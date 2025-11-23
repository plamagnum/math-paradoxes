<?php

session_start();

// Autoload controllers
spl_autoload_register(function ($class) {
    $controllerFile = __DIR__ . '/../app/controllers/' . $class . '.php';
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
    }
});

// Simple router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
if ($uri === '') {
    $uri = '/';
}

// Route handling
if ($uri === '/') {
    $controller = new HomeController();
    $controller->index();
} elseif (preg_match('/^\/paradox\/([a-fA-F0-9]{24})$/', $uri, $matches)) {
    $controller = new ParadoxController();
    $controller->show($matches[1]);
} elseif ($uri === '/admin' || $uri === '/admin/login') {
    $controller = new AdminController();
    $controller->login();
} elseif ($uri === '/admin/logout') {
    $controller = new AdminController();
    $controller->logout();
} elseif ($uri === '/admin/dashboard') {
    $controller = new AdminController();
    $controller->dashboard();
} elseif ($uri === '/admin/paradoxes') {
    $controller = new AdminParadoxController();
    $controller->index();
} elseif ($uri === '/admin/paradoxes/create') {
    $controller = new AdminParadoxController();
    $controller->create();
} elseif (preg_match('/^\/admin\/paradoxes\/edit\/([a-fA-F0-9]{24})$/', $uri, $matches)) {
    $controller = new AdminParadoxController();
    $controller->edit($matches[1]);
} elseif (preg_match('/^\/admin\/paradoxes\/delete\/([a-fA-F0-9]{24})$/', $uri, $matches)) {
    $controller = new AdminParadoxController();
    $controller->delete($matches[1]);
} elseif ($uri === '/admin/users') {
    $controller = new AdminUserController();
    $controller->index();
} elseif ($uri === '/admin/users/create') {
    $controller = new AdminUserController();
    $controller->create();
} elseif (preg_match('/^\/admin\/users\/edit\/([a-fA-F0-9]{24})$/', $uri, $matches)) {
    $controller = new AdminUserController();
    $controller->edit($matches[1]);
} elseif (preg_match('/^\/admin\/users\/delete\/([a-fA-F0-9]{24})$/', $uri, $matches)) {
    $controller = new AdminUserController();
    $controller->delete($matches[1]);
} else {
    http_response_code(404);
    echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>404 - Сторінка не знайдена</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1>404 - Сторінка не знайдена</h1>
        <p><a href="/">Повернутися на головну</a></p>
    </div>
</body>
</html>';
}
