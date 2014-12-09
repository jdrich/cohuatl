<?php

namespace Cohuatl;

class Config extends \Bismarck\Container
{
    private static $error_msgs = array(
        JSON_ERROR_NONE => 'No error',
        JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
        JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
    );

    public function __construct( $json_config )
    {
        $config = json_decode( $json_config, true );

        if( $config === null ) {
            throw new \InvalidArgumentException(
                'Error loading configuration: ' . $this->getJsonErrorMsg(json_last_error())
            );
        }

        foreach($config as $index => $configuration) {
            $this[$index] = $configuration;
        }
    }

    private function getJsonErrorMsg( $error )
    {
        return isset( self::$error_msgs[$error] ) ? self::$error_msgs[$error] : 'Unknown error.';
    }
}
