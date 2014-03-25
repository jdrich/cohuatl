<?php

if (preg_match('/\.(png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false;
}

session_start();

spl_autoload_register(
    function ($class) {
        include '../src/' . str_replace( '\\', '/', $class ) . '.php';
    }
);

$session_save = function( $session ) {
    $_SESSION = $session;
};

try {
    $router = new Cohuatl\Router(
        $_SERVER['REQUEST_URI'],
        new Cohuatl\Filter($_SERVER, $_GET, $_POST, $_FILES),
        new Cohuatl\Config(file_get_contents('../config.json')),
        new Cohuatl\User($_SESSION, $session_save)
    );

    $router->route();
} catch (Exception $e) {
    echo get_class($e) . ': ' . $e->getMessage();
}
