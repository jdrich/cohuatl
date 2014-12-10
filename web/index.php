<?php

if (preg_match('/\.(png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
    return false;
}

require_once '../vendor/autoload.php';

session_start();

$request_uri = $_SERVER['REQUEST_URI'];

try {
    $app = new Cohuatl\Application(
        new Cohuatl\Router(),
        new Cohuatl\Dispatcher(),
        new Cohuatl\User($_SESSION),
        Masticate\Filter::masticate()
    );

    $app->subsume(
        new Cohuatl\Config(file_get_contents('../config.json'))
    );

    $app->accept($request_uri);
} catch (Exception $e) {
    echo get_class($e) . ': ' . $e->getMessage();
}
