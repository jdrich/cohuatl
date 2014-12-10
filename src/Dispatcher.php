<?php

namespace Cohuatl;

class Dispatcher extends \Crier\BubblyEmitter {
    public function dispatch($event, $parameters = []) {
        $this->emit($event, [ 'event' => $event, 'parameters' => $parameters ]);
    }
}
