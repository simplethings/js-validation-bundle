<?php

namespace SimpleThings\JsValidationBundle\Twig\Extension;

use SimpleThings\JsValidationBundle\ConstraintsGenerator;

/**
 * @author David Badura <badura@simplethings.de>
 */
class ValidationExtension extends \Twig_Extension
{
    /**
     *
     * @var ConstraintsGenerator
     */
    private $generator;

    /**
     *
     * @var array
     */
    private $objects;

    /**
     *
     * @param ConstraintsGenerator $generator
     * @param array                            $objects
     */
    public function __construct(ConstraintsGenerator $generator, array $objects)
    {
        $this->generator = $generator;
        $this->objects   = $objects;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'simplethings_js_validation' => new \Twig_Function_Method(
                $this,
                'getValidationConstraints',
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Generates a JSON representation of the validation constraints that are
     * exported to the client-side.
     *
     * @return string
     */
    public function getValidationConstraints()
    {
        return $this->generator->generate($this->objects);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'simplethings_jsvalidation_validation';
    }
}
