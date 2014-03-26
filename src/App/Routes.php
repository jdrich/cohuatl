<?php

namespace App;

class Routes extends \Cohuatl\Routes
{
    public function __construct() {
        $this->routes['/'] = function ( $params, $config, $filter, $user ) {
            echo "Hello, world!\n";
        };

        $this->routes['/franklin'] = function () {
            echo "Hello, Benjamin!\n";
        };

        $this->routes['/hello/:name'] = function ( $params ) {
            echo "Hello, " . $params['name'] . "!\n";
        };

        $this->routes['/hello/:first/:last'] = function ( $params ) {
            echo "Hello, " . $params['first'] . ' ' . $params['last'] . "!\n";
        };
    }
}
