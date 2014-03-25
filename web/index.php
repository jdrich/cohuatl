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
        new Cohuatl\Config(file_get_contents('../config.json')),
        new Cohuatl\Filter($_SERVER, $_GET, $_POST, $_FILES),
        new Cohuatl\User($_SESSION, $session_save)
    );

    $router->route($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo get_class($e) . ': ' . $e->getMessage();
}
