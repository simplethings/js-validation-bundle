<?php

namespace SimpleThings\JsValidationBundle;

use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class ConstraintsGenerator
{
    /**
     * @var MetadataFactoryInterface
     */
    protected $metadataFactory;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var string
     */
    protected $defaultLocale;

    /**
     * @param MetadataFactoryInterface $metadataFactory
     * @param TranslatorInterface      $translator
     * @param string                   $defaultLocale
     */
    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        TranslatorInterface $translator = null,
        $defaultLocale = null
    ) {
        $this->metadataFactory = $metadataFactory;
        $this->translator      = $translator;
        $this->defaultLocale   = $defaultLocale;
    }

    /**
     * @param array $classNames
     * @return string
     */
    public function generate(array $classNames)
    {
        $data = array();
        foreach ($classNames as $className) {
            $data[$className] = $this->generateClass($className);
        }

        return json_encode($data);
    }

    /**
     * Generate array representation of constraints that is exported to JSON.
     *
     * @param string $className
     * @return array
     */
    public function generateClass($className)
    {
        $data = array();

        $metadata   = $this->metadataFactory->getMetadataFor($className);
        $properties = $metadata->getConstrainedProperties();

        foreach ($properties as $property) {
            $data[$property] = array();
            $constraintsList = $metadata->getPropertyMetadata($property);
            foreach ($constraintsList as $constraints) {
                foreach ($constraints->constraints as $constraint) {
                    $const = clone $constraint;
                    if ($this->translator) {
                        $const->message = $this->translator->trans(
                            $const->message,
                            array(),
                            'validations',
                            $this->defaultLocale
                        );
                    }
                    $data[$property][$this->getConstraintName($const)] = $const;
                }
            }
        }

        return $data;
    }

    /**
     * @todo Only shorten symfony ones and underscore/camlize others?
     * @param Constraint $constraint
     * @return string
     */
    protected function getConstraintName(Constraint $constraint)
    {
        $class = get_class($constraint);
        $parts = explode('\\', $class);

        return lcfirst(array_pop($parts));
    }
}

