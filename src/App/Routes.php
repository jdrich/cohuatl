<?php

namespace App;

class Routes extends \Cohuatl\Routes
{
    public function __construct() {
        // User defined routes go here.
        $this->routes['/'] = function ( $params, $config, $filter, $user ) {
            $hello = new Hello\Hello();

            $hello->hello();
        };
    }
}
