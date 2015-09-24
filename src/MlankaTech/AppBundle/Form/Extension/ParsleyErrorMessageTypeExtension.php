<?php

namespace MlankaTech\AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Extension\ParsleyErrorMessageTypeExtension
 *
 * @DI\Service("mlanka_tech_app.form.type.parsley_error_message")
 * @DI\Tag("form.type_extension", attributes = {"alias" = "form"}) 
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form
 * @version 0.0.1 
 * 
 */
class ParsleyErrorMessageTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('parsley_error_container', $options['parsley_error_container']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['parsley_error_container'] = $form->getConfig()->getAttribute('parsley_error_container');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'parsley_error_container' => null,
        ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}

