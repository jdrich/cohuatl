<?php

namespace Cohuatl;

class Application extends \Bismarck\Container {
    public function __construct(Router $router, Dispatcher $dispatcher, User $user, \Masticate\Filter $filter ) {
        $this['_router'] = $router;
        $this['_dispatcher'] = $dispatcher;
        $this['_user'] = $user;
        $this['_filter'] = $filter;

        $this->init();

        $router->addRoute('/:module/', '_default');
        $router->addRoute('/:module/:command', '_default');

        $dispatcher->app($this);
        $dispatcher->define('_default');

        $dispatcher->listener(
            '_default',
            function(Application $app, $parameters) {
                $event = $parameters['module'];

                if(isset($parameters['command'])) {
                    $event .= '.' . $parameters['command'];
                }

                $app['_dispatcher']->dispatch($event, $parameters);
            }
        );
    }

    protected function init() {
        // Define routes and events here.
    }

    public function accept($request_uri) {
        $route = $this['_router']->match($request_uri);

        $this['_dispatcher']->dispatch($route['event'], $route['parameters']);
    }

}
