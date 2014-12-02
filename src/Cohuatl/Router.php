<?php

namespace Cohuatl;

class Router
{
    private $routes = array();

    public function __construct()
    {
    }

    public function route( $uri, Container $container )
    {
        $uri = $this->cleanGetParams( $uri );

        $route = $this->match( $uri );

        if( $route === null ) {
            throw new \InvalidArgumentException( 'Unable to determine route.' );
        }

        $this->call( $route['method'], $route['captures'], $container );
    }

    public function addRoute( $route, callable $method )
    {
        $route_regex = $this->decomposeRoute( $route );

        $this->routes[ $route_regex ] = $method;
    }

    private function call( $method, $params, Container $container ) {
        $method( $params, $container );
    }

    private function decomposeRoute( $route )
    {
        $match = '/^\/$/';

        if ( $route != '/' ) {
            $chunks = explode( '/', $route );

            $match = '/^';

            foreach( $chunks as $chunk ) {
                if( $chunk === '' ) {
                    continue;
                }

                $match .= '\/';

                if( $chunk[0] === ':' ) {
                    $capture = substr( $chunk, 1 );

                    $match .= '(?P<' . $capture . '>[^\/]+)';
                } else {
                    $match .= $chunk;
                }
            }

            if($chunk === '') {
                $match .= '\/';
            }

            $match .= '$/';
        }

        return $match;
    }

    private function match( $route )
    {
        foreach( $this->routes as $pattern => $method ) {
            if( $this->pregMatchCapture( $pattern, $route, $captures ) ) {
                return array(
                    'method' => $method,
                    'captures' => $captures
                );
            }
        }

        return null;
    }

    private function pregMatchCapture( $pattern, $route, &$captures) {
        $match = preg_match( $pattern, $route, $captures );

        if( $match === 0 ) {
            return 0;
        }

        foreach ( $captures as $key => $capture ) {
            if( is_int( $key ) ) {
                unset( $captures[$key] );
            }
        }

        return 1;
    }

    private function cleanGetParams( $uri ) {
        $pos_inter = strpos( $uri, '?' );

        if( $pos_inter === false ) {
            return $uri;
        } else {
            return substr( $uri, 0, $pos_inter );
        }
    }
}
