<?php

spl_autoload_register(
    function ($class) {
        $autoload_path = '../src/' . str_replace( '\\', '/', $class ) . '.php';

        if( file_exists($autoload_path) ) {
            include $autoload_path;
        }
    }
);
