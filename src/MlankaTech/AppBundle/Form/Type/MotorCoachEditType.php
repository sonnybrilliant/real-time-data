<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Type\MotorCoachEditType
 *
 * @DI\Service("mlanka_tech_app.form.type.motor.coach.edit")
 * @DI\Tag("form.type", attributes = {"alias" = "MotorCoachEditType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class MotorCoachEditType extends AbstractType
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
            ))

            ->add('status', 'entity', array(
                'placeholder' => 'Select status',
                'class' => 'MlankaTechAppBundle:Status',
                'label' => 'Status ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '3',
                    'data-parsley-errors-container' => '#parsleyStatus',
                    'data-parsley-required-message' => 'Status is required.',
                ),
                'help' => 'Motor coach status',
                'parsley_error_container' => 'parsleyStatus',
            ))

            ->add('condition', 'entity', array(
                'placeholder' => 'Select condition',
                'class' => 'MlankaTechAppBundle:Condition',
                'label' => 'Condition ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '4',
                    'data-parsley-errors-container' => '#parsleyCondition',
                    'data-parsley-required-message' => 'Condition is required.',
                ),
                'help' => 'Motor coach condition',
                'parsley_error_container' => 'parsleyCondition',
            ))

            ->add('train', 'entity', array(
                'placeholder' => 'Select train',
                'class' => 'MlankaTechAppBundle:Train',
                'label' => 'Type ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '3',
                ),
                'help' => 'Assigned train',
                'required' => false
           ))

            ->add('assigned', 'checkbox', array(
                'label' => 'Is assigned? ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '4',
                ),
                'required' => false
            ))
        ;

    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'MotorCoachEditType';
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