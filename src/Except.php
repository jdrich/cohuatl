<?php

namespace Cohuatl;

class Except extends Module {
    protected function listen(Dispatcher $dispatcher) {
        $dispatcher->define([ 'exception' ]);
        $dispatcher->listener('exception', $this->contextualize('exception'));
    }

    public function exception($event, $parameters) {
        header('500 Internal Server Error', true, 500);

        $echo = '<html><head><title>Cohuatl Exception</title></head><body>';

        $echo .= '<h2>' . $parameters['class'] . '</h2>';
        $echo .= '<h4>' . $parameters['file'] . ': line ' . $parameters['line'] . '</h4>';
        $echo .= '<p>' .  $parameters['message'] . '</p></body></html>';

        echo $echo;
    }
}
