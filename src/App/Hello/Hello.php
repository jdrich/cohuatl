<?php

namespace App\Hello;

class Hello
{
    public function __construct() {
        \Cohuatl\View::getInstance()->register(__DIR__);
    }

    public function hello() {
        $store = new \Cohuatl\Store( 'hello' );

        $hello = $store->next();

        $message = $hello['message'];
        $times = ++$hello['times'];

        $store->save( $hello );

        include 'views/hello.php';
    }

    public function pastrami($params) {
        $template = \Cohuatl\View::getInstance();

        echo $template->get('views/layout.php', ['content' => $template->get('views/pastrami.php', $params)]);
    }
}
