<?php

namespace SimpleThings\JsValidationBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *
 * @author David Badura <badura@simplethings.de>
 */
class ValidationTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    private $validatedObjects = array();

    /**
     * @param array $validatedObjects
     */
    public function __construct($validatedObjects)
    {
        $this->validatedObjects = array_flip($validatedObjects);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($this->validatedObjects[$options['data_class']])) {
            return;
        }

        if (!isset($attr['data-simplethings-validation-class'])) {
            $attr['data-simplethings-validation-class'] = $options['data_class'];
            $builder->setAttribute('attr', $attr);
        }
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'form';
    }
}