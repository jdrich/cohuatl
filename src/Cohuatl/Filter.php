<?php

namespace Cohuatl;

class Filter
{
    private $supers = array();

    public function __construct( $server, $get, $post, $files ) {
        $supers['server'] = $server;
        $supers['get'] = $get;
        $supers['post'] = $post;
        $supers['files'] = $files;
    }

    public function has( $super, $value ) {
        if( !isset( $this->supers[$super]) ) {
            return false;
        }

        $super = $this->supers[$super];

        return isset( $super[$value] );
    }

    public function get( $super, $value, $filter, $options = array() ) {
        if( !isset( $this->supers[$super]) ) {
            return false;
        }

        $super = $this->supers[$super];

        if( !isset( $super[$value] ) ) {
            return null;
        }

        $filter = $this->filterFilter( $filter );

        return filter_var($super[$value], $filter, $options);
    }

    private function filterFilter( $filter )
    {
        if( is_int($filter) ) {
            return $filter;
        }

        $filter = strtoupper( $filter );

        if(strpos($filter, 'FILTER') !== 0) {
            $filter = 'FILTER_' . $filter;
        }

        if(!defined($filter)) {
            throw new \UnexpectedValueException( 'Undefined validation filter: ' . $filter );
        }

        return constant( $filter );
    }
}
