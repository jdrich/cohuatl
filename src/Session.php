<?php

namespace Cohuatl;

class Session {
    private $session;

    public function __construct( &$session )
    {
        $this->session = &$session;
    }

    public function get($key) {
        return $this->has($key) ? $this->session[$key] : null;
    }

    public function set($key, $value) {
        return $this->session[$key] = $value;
    }

    public function has($key) {
        return isset($this->session[$key]);
    }

    /**
     * Yes I know it's not a real word.
     */
    public function deset($key) {
        unset($this->session[$key]);
    }
}
