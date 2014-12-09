<?php

namespace Cohuatl;

class Dispatcher extends \Crier\BubblyEmitter {
    private $app;

    public function app(Application $app) {
        $this->app = $app;
    }

    public function dispatch($event, $parameters) {
        $this->emit($event, $parameters);
    }

    protected function emit($event, $parameters = false) {
        parent::emit($event, [$this->app, $parameters]);
    }
}
