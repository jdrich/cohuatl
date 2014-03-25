<?php

namespace Cohuatl;

class Router
{
    private $filter;

    private $config;

    private $user;

    private $routes = array();

    public function __construct( $config, $filter, $user )
    {
        $this->config = $config;
        $this->filter = $filter;
        $this->user = $user;
    }

    public function route( $uri )
    {
        $method = $this->match( $uri );

        if( $method === null ) {
            throw new \InvalidArgumentException( 'Unable to determine route.' );
        }

        $method( $this->config, $this->filter, $this->user );
    }

    public function addRoute( $route, callable $method )
    {

    }

    private function decomposeRoute( $route )
    {
        $chunks = explode( '/', $route );

        $match = '/^';

        foreach( $chunks as $chunk ) {
            if( $chunk[0] === ':' ) {
                $match .= '[^\/]+';
            } else {
                $match .= $chunk;
            }

            $match .= '\/';
        }

        $match .= '$/';
    }

    private function match( $route )
    {
        return null;
    }
}
