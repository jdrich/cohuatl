<?php

namespace Cohuatl;

class User extends Lib\ArrayAccess
{
    private $session_save = null;

    private static $default = array(
        'cohuatl.session' => true,
        'cohuatl.is_admin' => false,
        'cohuatl.logged_in' => false
    );

    public function __construct( array $session, callable $session_save )
    {
        $this->accessee = $session;
        $this->session_save = $session_save;

        $this->setup();
    }

    public function __destruct()
    {
        $save = $this->session_save;

        $save( $this->accessee );
    }

    private function setup()
    {
        if( !isset($this->accessee['cohuatl.session']) ) {
            $this->accessee = array_merge( $this->accessee, self::$default );
        }
    }
}
