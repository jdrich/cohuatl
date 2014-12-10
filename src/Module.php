<?php

namespace Cohuatl;

abstract class Module {
    protected $app;

    final public function __construct(Application $app) {
        $this->app = $app;
    }

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

    protected function templateDir() {
        return '';
    }

    protected function get($template, $params = []) {
        extract($params);

        ob_start();

        include $this->templateDir() . \DIRECTORY_SEPARATOR . $template;

        return ob_get_clean();
    }
}
