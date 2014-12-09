<?php

namespace Cohuatl;

class User
{
    private $session_save = null;

    private static $default = array(
        'cohuatl.session' => true,
        'cohuatl.is_admin' => false,
        'cohuatl.logged_in' => false
    );

    public function __construct( $session )
    {
        $this->accessed = $session;
        $this->session_save = $session;

        $this->setup();
    }

    public function __destruct()
    {
        /*$save = $this->session_save;

        $save( $this->accessed );*/
    }

    public function login($is_admin = false) {
        $this['cohuatl.logged_in'] = true;
        $this['cohuatl.is_admin'] = $is_admin;
    }

    public function logout() {
        $this['cohuatl.logged_in'] = false;
        $this['cohuatl.is_admin'] = false;
    }

    public function isLoggedIn() {
        return $this['cohuatl.logged_in'];
    }

    public function isAdmin() {
        return $this['cohuatl.is_admin'];
    }

    public function clear() {
        $this->accessed = array();
        $this->setup();
    }

    private function setup()
    {
        /*if( !isset($this->accessed['cohuatl.session']) ) {
            $this->accessed = array_merge( $this->accessed, self::$default );
        }*/
    }
}
