<?php

namespace Cohuatl;

class Template {
    private $paths = [];

    public function __construct($paths = []) {
        foreach($paths as $path) {
            $this->register($path);
        }
    }

    public function register($path) {
        $this->paths[] = $path;
    }

    public function get($template, $params = []) {
        foreach( $this->paths as $path ) {
            if(file_exists($path . DIRECTORY_SEPARATOR . $template)) {
                extract($params);

                ob_start();

                include $path . DIRECTORY_SEPARATOR . $template;

                return ob_get_clean();
            }
        }

        throw new \RuntimeException( 'Could not find template: ' . $template );
    }
}
