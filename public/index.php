<?php
if (!session_id()) @session_start();

require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', '/login', ['App\controllers\HomeController', 'login']);
    $r->addRoute('GET', '/register', ['App\controllers\HomeController', 'register']);
    $r->addRoute('POST', '/registerUser', ['App\controllers\HomeController', 'registerUser']);
    $r->addRoute('POST', '/loginUser', ['App\controllers\HomeController', 'loginUser']);
    $r->addRoute('GET', '/verify_email', ['App\controllers\HomeController', 'verify_email']);
    $r->addRoute('GET', '/logout', ['App\controllers\HomeController', 'logout']);
    $r->addRoute('GET', '/profile', ['App\controllers\HomeController', 'profile']);
    $r->addRoute('POST', '/addComment', ['App\controllers\HomeController', 'addComment']);
    $r->addRoute('POST', '/updateUser', ['App\controllers\HomeController', 'updateUser']);
    $r->addRoute('GET', '/admin', ['App\controllers\HomeController', 'admin']);
    $r->addRoute('GET', '/changeAccessComment', ['App\controllers\HomeController', 'changeAccessComment']);
    $r->addRoute('GET', '/deleteComment', ['App\controllers\HomeController', 'deleteComment']);
    $r->addRoute('POST', '/updatePassword', ['App\controllers\HomeController', 'updatePassword']);

    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo '404';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo '405';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        $class = new $handler[0];
        call_user_func([$class, $handler[1]], $vars);
        break;
}
