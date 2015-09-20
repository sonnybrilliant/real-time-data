<?php

namespace MlankaTech\AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Extension\DateIconTypeExtension
 *
 * @DI\Service("mlanka_tech_app.form.type.date_icon")
 * @DI\Tag("form.type_extension", attributes = {"alias" = "form"}) 
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form
 * @version 0.0.1 
 * 
 */
class DateIconTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('date_icon', $options['date_icon']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['date_icon'] = $form->getConfig()->getAttribute('date_icon');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'date_icon' => null,
        ));
    }

    public function getExtendedType()
    {
        return 'form';
    }
}

