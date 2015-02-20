<?php

namespace SimpleThings\JsValidationBundle\Tests\DependencyInjection;

use SimpleThings\JsValidationBundle\DependencyInjection\SimpleThingsJsValidationExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SimpleThingsJsValidationExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $extension = new SimpleThingsJsValidationExtension();
        $extension->load(
            array(
                array(
                    'objects' => array('stdClass')
                ),
            ),
            $container
        );

        $this->assertTrue($container->hasDefinition('simple_things_js_validation.form.extension.validation'));
        $this->assertEquals(
            array('stdClass'),
            $container->getParameter('simple_things_js_validation.objects')
        );
    }

    public function testLoadAllowsEmptyConfig()
    {
        $container = new ContainerBuilder();
        $extension = new SimpleThingsJsValidationExtension();
        $extension->load(array(array()), $container);
    }
}
