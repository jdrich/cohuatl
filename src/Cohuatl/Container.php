<?php

namespace Cohuatl;

class Container extends \Bismarck\Container {
    public function __construct(Config $config, User $user, Filter $filter) {
        $this['config'] = function() use ($config) {
            return $config;
        };

        $this['user'] = function() use ($user) {
            return $user;
        };

        $this['filter'] = function() use ($filter) {
            return $filter;
        };
    }
}
