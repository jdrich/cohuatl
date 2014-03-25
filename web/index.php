<?php

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
        new Cohuatl\Filter($_SERVER, $_GET, $_POST, $_FILES),
        new Cohuatl\Config(file_get_contents('../config.json')),
        new Cohuatl\User($_SESSION, $session_save)
    );

    $router->route();
} catch (Exception $e) {
    echo $e->getMessage();
}
