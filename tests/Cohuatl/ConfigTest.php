<?php

namespace tests\Cohuatl;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorThrowExceptionOnBadJson() {
        $this->setExpectedException( 'InvalidArgumentException' );

        $config = new \Cohuatl\Config( 'baconnaise' );
    }
}
