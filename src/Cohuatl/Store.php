<?php

namespace Cohuatl;

class Store {
    private $store;

    private $index;

    private $data;

    public function __construct( $store ) {
        if( !$this->validStoreName( $store ) ) {
            throw new \UnexpectedValueException( 'Invalid store name provided: "' . $store . '"' );
        }

        if( !$this->storeExists( $store ) ) {
            $this->createStore( $store );
        }

        $this->index = -1;
        $this->store = $store;
        $this->data = array();
    }

    public function hasNext() {
        $next = $this->index + 1;

        return file_exists( $this->getItemFilename( $next ) );
    }

    public function current() {
        return ( $this->index >= 0 ) ? $this->data : null;
    }

    public function first() {
        return $this->get(0);
    }

    public function last() {
        while($this->hasNext()) {
            $this->index++;
        }

        return $this->get();
    }

    public function next() {
        if( $this->hasNext() ) {
            return $this->get($this->index + 1);
        }

        return null;
    }

    public function prev() {
        if( $this->index > 0 ) {
            return $this->get($this->index - 1);
        }

        return null;
    }

    public function get($index = null) {
        if(!ctype_digit((string)$index)) {
            throw new \RuntimeException( 'Invalid index: ' . $index );
        }

        if( $index === null ) {
            $index = $this->index;
        }

        if($index < 0) {
            return null;
        }

        $json = file_get_contents( $this->getItemFilename( $index ) );

        if( $json === false ) {
            throw new \RuntimeException( 'Could not get contents of: ' . $this->getItemFilename( $index ) );
        }

        $data = json_decode( $json, true );

        if( $data === null ) {
            throw new \RuntimeException( 'Could not parse JSON from: ' . $json );
        }

        $this->data = $data;
        $this->index = $index;

        return $this->data;
    }

    public function getDefault() {
        $default = $this->getItemFilename( 'default' );

        if(file_exists($default)) {
            $json = file_get_contents( $default );

            if( $json === false ) {
                throw new \RuntimeException( 'Could not access defaults for ' . $this->store );
            }

            $data = json_decode( $json, true );

            if( $data === null ) {
                throw new \RuntimeException( 'Could not parse defaults for ' . $this->store );
            }

            return $data;
        } else {
            return [];
        }
    }

    public function save( array $data ) {
        if( $this->index < 0 ) {
            $this->create($data);
        }

        $json = json_encode( $data );

        if( $json === false ) {
            throw new \RuntimeException( 'Could not convert save data to JSON.' );
        }

        $success = file_put_contents( $this->getItemFilename( $this->index ), $json );

        if( $success === false ) {
            throw new \RuntimeException( 'Could not save to: ' . $this->getItemFilename( $this->index ) );
        }
    }

    public function create( array $data ) {
        while( $this->hasNext() ) {
            $this->index++;
        }

        $this->index++;

        $this->save( $data );
    }

    private function storeExists( $store ) {
        $store_dir = $this->getStoreDir() . \DIRECTORY_SEPARATOR . $store;

        return file_exists( $store_dir ) && is_dir( $store_dir );
    }

    private function createStore( $store ) {
        $store_dir = $this->getStoreDir( $store );

        if(!mkdir($store_dir, 0755)) {
            throw new \RuntimeException( 'Could not create directory: ' . $store_dir );
        }
    }

    private function getStoreDir( $store = null ) {
        $store_root = dirname(getcwd()) . \DIRECTORY_SEPARATOR . 'data';

        return $store_root . ( $store === null ? '' :  \DIRECTORY_SEPARATOR . $store );
    }

    private function validStoreName( $store ) {
        return preg_match( '/^[a-zA-Z\d]+$/', $store );
    }

    private function getItemFilename( $item ) {
        return $this->getStoreDir( $this->store ) . \DIRECTORY_SEPARATOR . $item . '.json';
    }
}
