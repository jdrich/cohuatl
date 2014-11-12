<?php

namespace App\Auth;

class Auth {
    public function route( $params, $config, $filter, $user ) {
        $action = $params['action'];

        $this->$action( $params, $config, $filter, $user );
    }

    private function login( $params, $config, $filter, $user ) {
        if( $user['cohuatl.logged_in'] ) {
            header('Location: /');
            exit();
        }

        if( !$filter->has('post', 'submit')) {
            $this->loginForm($filter);

            return;
        }

        if( $filter->get('post', 'username') == 'foo' &&
           $filter->get('post', 'password') == 'bar'
        ) {
            $user['cohuatl.logged_in'] = true;

            header('Location: /');
            exit();
        }

        echo 'Invalid login.';
    }

    private function logout( $params, $config, $filter, $user ) {
        $user['cohuatl.logged_in'] = false;
        $user['cohuatl.is_admin'] = false;

        header('Location: /auth/login');
        exit();
    }

    private function loginForm($filter) {
        include 'views/login.php';
    }
}
