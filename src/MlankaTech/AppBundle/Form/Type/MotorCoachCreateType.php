<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Type\MotorCoachCreateType
 *
 * @DI\Service("mlanka_tech_app.form.type.motor.coach.create")
 * @DI\Tag("form.type", attributes = {"alias" = "MotorCoachCreateType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class MotorCoachCreateType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unit', 'text', array(
                'label' => 'Unit name ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'data-parsley-errors-container' => '#parsleyUnit',
                    'data-parsley-required-message' => 'Unit name is required.',
                ),
                'help' => 'Motor coach unit name',
                'parsley_error_container' => 'parsleyUnit',
            ))

            ->add('type', 'entity', array(
                'placeholder' => 'Select type',
                'class' => 'MlankaTechAppBundle:MotorCoachType',
                'label' => 'Type ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '2',
                    'data-parsley-errors-container' => '#parsleyType',
                    'data-parsley-required-message' => 'Type is required.',
                ),
                'help' => 'Motor coach type',
                'parsley_error_container' => 'parsleyType',
            ));

    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'MotorCoachCreateType';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MlankaTech\AppBundle\Entity\MotorCoach',
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MlankaTech\AppBundle\Entity\MotorCoach',
        ));
    }
}