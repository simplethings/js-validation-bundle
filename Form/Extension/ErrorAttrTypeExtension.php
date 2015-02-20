<?php

namespace SimpleThings\JsValidationBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Translation\TranslatorInterface;

/**
 *
 * @author David Badura <badura@simplethings.de>
 */
class ErrorAttrTypeExtension extends AbstractTypeExtension
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $errors      = array();
        $fieldErrors = $form->getErrors();

        foreach ($fieldErrors as $fieldError) {
            $errors[] = $this->translator->trans(
                $fieldError->getMessageTemplate(),
                $fieldError->getMessageParameters(),
                'validators'
            );
        }

        if ($errors) {
            $view->vars['attr']['data-error'] = implode("<br>", $errors);
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