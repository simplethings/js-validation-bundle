<?php

namespace SimpleThings\JsValidationBundle\Tests;

use SimpleThings\JsValidationBundle\SimpleThingsJsValidationBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SimpleThingsJsValidationBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $container = new ContainerBuilder();
        $bundle = new SimpleThingsJsValidationBundle();

        $bundle->build($container);
    }
}
