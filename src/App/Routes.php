<?php

namespace App;

class Routes extends \Cohuatl\Routes
{
    public function __construct() {
        // User defined routes go here.
        $this->routes['/'] = function () {
            $hello = new Hello\Hello();

            $hello->hello();
        };

        // User defined routes go here.
        $this->routes['/pastrami/:rye'] = function ( $params ) {
            $hello = new Hello\Hello();

            $hello->pastrami($params);
        };

        $this->routes['/blog'] = function ( $params ) {
            $blog = new Blog\Blog();

            $blog->index();
        };

        $this->routes['/blog/create'] = function ( $params ) {
            $blog = new Blog\Blog();

            $blog->create();
        };

        $this->routes['/blog/save'] = function ( $params ) {
            $blog = new Blog\Blog();

            $blog->save();
        };
    }
}
