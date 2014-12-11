<?php

namespace Cohuatl;

class Application extends \Bismarck\Container {
    public function __construct(Router $router, Dispatcher $dispatcher, User $user, \Masticate\Filter $filter ) {
        parent::__construct();

        $this['_router'] = $router;
        $this['_dispatcher'] = $dispatcher;
        $this['_user'] = $user;
        $this['_filter'] = $filter;

        $this['_template'] = $this->factory(
            function () {
                return new Template();
            }
        );

        $this->init();

        $router->connect('/:module/', '_default');
        $router->connect('/:module/:command', '_default');

        $dispatcher->define('_default');

        $dispatcher->listener(
            '_default',
            function($event, $parameters) {
                $event = $parameters['module'];

                if(isset($parameters['command'])) {
                    $event .= '.' . $parameters['command'];
                }

                $this['_dispatcher']->dispatch($event, $parameters);
            }
        );
    }

    protected function init() {
        (new Auth($this))->attach();
    }

    public function accept($request_uri) {
        $route = $this['_router']->match($request_uri);

        $this['_dispatcher']->dispatch($route['event'], $route['parameters']);
    }

}
