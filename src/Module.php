<?php

namespace Cohuatl;

abstract class Module {
    protected $app;

    public function attach() {
        $this->connect($this->app['_router']);
        $this->listen($this->app['_dispatcher']);
    }

    protected function contextualize($method) {
        return function ($event, $parameters) use ($method) { return $this->$method($event, $parameters); };
    }

    protected function connect(Router $router) {

    }

    protected function listen(Dispatcher $dispatcher) {

    }

    final public function __construct(Application $app) {
        $this->app = $app;
    }
}
