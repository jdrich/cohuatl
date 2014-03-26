<?php

namespace App\Hello;

class Hello
{
    public function hello() {
        $store = new \Cohuatl\Store( 'hello' );

        $hello = $store->next();

        $message = $hello['message'];
        $times = ++$hello['times'];

        include 'views/hello.php';

        $store->save( $hello );
    }
}
