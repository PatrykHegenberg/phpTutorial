<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'controllers/index.php',
    '/about' => 'controllers/about.php',
    '/contact' => 'controllers/contact.php',
    '/learn' => 'controllers/learn.php',
    '/mathe' => 'controllers/mathe.php',
    '/note' => 'controllers/note.php',
    '/notes' => 'controllers/notes.php',
    '/addition' => 'controllers/addition.php'
];

function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

routeToController($uri, $routes);

function abort($code = 404) {
    http_response_code($code);
    require "views/{$code}.php";
    die();
}