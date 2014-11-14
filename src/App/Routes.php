<?php

namespace App;

class Routes extends \Cohuatl\Routes
{
    public function __construct() {
        $this->routes['/'] = function ( $params, $config, $filter, $user ) {
            if(!(new \Cohuatl\Store('BlogConfig'))->hasNext()) {
                $this->routes['/setup']($params, $config, $filter, $user);
            } else {
                (new Blog\Blog($params, $config, $filter, $user))->index();
            }
        };

        $this->routes['/setup'] = function ($params, $config, $filter, $user) {
            (new Setup\Setup($params, $config, $filter, $user))->index();
        };
    }
}
