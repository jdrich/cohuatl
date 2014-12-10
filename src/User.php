<?php

namespace Cohuatl;

class User implements \ArrayAccess
{
    private $session;

    protected $user;

    private $default = array(
        '_cohuatl.session' => true,
        '_cohuatl.is_admin' => false,
        '_cohuatl.logged_in' => false,
        '_cohuatl.user' => []
    );

    public function __construct( &$session )
    {
        $this->session = &$session;

        $this->setup();

        $this->user = &$this->session['_cohuatl.user'];
    }

    public function login($is_admin = false) {
        $this->session['_cohuatl.logged_in'] = true;
        $this->session['_cohuatl.is_admin'] = $is_admin;
    }

    public function logout() {
        $this->session['_cohuatl.logged_in'] = false;
        $this->session['_cohuatl.is_admin'] = false;
    }

    public function isLoggedIn() {
        return $this->session['_cohuatl.logged_in'];
    }

    public function isAdmin() {
        return $this->session['_cohuatl.is_admin'];
    }

    public function offsetExists($offset) {
        return isset($this->user[$offset]);
    }

    public function offsetGet($offset) {
        return $this->user[$offset];
    }

    public function offsetSet($offset, $value) {
        return $this->user[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->user[$offset]);
    }

    private function clear() {
        $this->session['_cohuatl.session'] = false;

        $this->setup();
    }

    private function setup()
    {
        if( !$this->session['_cohuatl.session'] ) {
            foreach($this->default as $key => $value) {
                $this[$key] = $value;
            }
        }
    }
}
