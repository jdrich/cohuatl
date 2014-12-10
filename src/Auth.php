<?php

namespace Cohuatl;

class Auth extends Module {
    protected function listen(Dispatcher $dispatcher) {
        $dispatcher->define([ 'auth' ]);;

        $dispatcher->listener(
            '.',
            $this->contextualize('checkUser')
        );
    }

    public function checkUser($event, $parameters) {
        // Don't emit default events.
        if(strpos($event, '_') === 0) {
            return;
        }

        $base = substr($event, 0, strpos($event, '.'));

        // We don't want to emit on ourselves.
        if($base === 'auth') {
            return;
        }

        $app = $this->app;

        if($app['_user']->isLoggedIn()) {
            $app['_dispatcher']->dispatch('auth.user.' . $event, $parameters);
        }

        if($app['_user']->isAdmin()) {
            $app['_dispatcher']->dispatch('auth.admin.' . $event, $parameters);
        }
    }
}
