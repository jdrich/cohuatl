<?php

namespace Cohuatl;

class Filter
{
    private $supers = array();

    public function __construct( array $get, array $post, array $files, array $server ) {
        $supers = &$this->supers;

        $supers['get'] = $get;
        $supers['post'] = $post;
        $supers['files'] = $files;
        $supers['server'] = $server;
    }

    public function has( $super, $value ) {
        if( !isset( $this->supers[$super]) ) {
            return false;
        }

        $super = $this->supers[$super];

        return isset( $super[$value] );
    }

    public function get($value, $filter = \FILTER_SANITIZE_STRING, array $options = array()) {
        return $this->supers('get', $value, $filter, $options);
    }

    public function post($value, $filter = \FILTER_SANITIZE_STRING, array $options = array()) {
        return $this->supers('post', $value, $filter, $options);
    }

    public function files($value, $filter = \FILTER_UNSAFE_RAW, array $options = array()) {
        return $this->supers('files', $value, $filter, $options);
    }

    public function server($value, $filter = \FILTER_SANITIZE_STRING, array $options = array()) {
        return $this->supers('server', $value, $filter, $options);
    }

    public function supers( $super, $value, $filter = \FILTER_SANITIZE_STRING, array $options = array() ) {
        $super = strtolower( $super );

        if( !isset( $this->supers[$super]) ) {
            return false;
        }

        $super = $this->supers[$super];

        if( !isset( $super[$value] ) ) {
            return null;
        }

        $filter = $this->filterFilter( $filter );

        if(is_array($super[$value])) {
            return filter_var_array($super[$value], $filter, $options);
        } else {
            return filter_var($super[$value], $filter, $options);
        }
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
