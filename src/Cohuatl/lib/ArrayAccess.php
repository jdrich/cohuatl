<?php

namespace Cohuatl\lib;

class ArrayAccess implements \ArrayAccess
{
    protected $accessed = array();

    public function offsetExists ( $offset ) {
        return isset( $this->accessed[$offset] );
    }

    public function offsetGet ( $offset ) {
        return $this->accessed[$offset];
    }

    public function offsetSet ( $offset , $value ) {
        $accessed[ $offset ] = $value;
    }

    public function offsetUnset ( $offset ) {
        if( isset( $accessed[ $offset ] ) ) {
            unset( $accessed[ $offset ] );
        }
    }
}
