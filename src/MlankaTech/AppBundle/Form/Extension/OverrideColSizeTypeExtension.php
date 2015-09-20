<?php

namespace MlankaTech\AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Extension\OverrideColSizeTypeExtension.php
 *
 * @DI\Service("mlanka_tech_app.form.type.overide_col_size_message")
 * @DI\Tag("form.type_extension", attributes = {"alias" = "form"}) 
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form
 * @version 0.0.1 
 * 
 */
class OverrideColSizeTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('override_col_size', $options['override_col_size']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['override_col_size'] = $form->getConfig()->getAttribute('override_col_size');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'override_col_size' => null,
        ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}

