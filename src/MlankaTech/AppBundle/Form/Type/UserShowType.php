<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Type\UserShowType
 *
 * @DI\Service("mlanka_tech_app.form.type.user.show")
 * @DI\Tag("form.type", attributes = {"alias" = "UserShowType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 *
 */
class UserShowType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('title', 'entity', array(
                'empty_value' => 'Select title',
                'class' => 'MlankaTechAppBundle:Title',
                'label' => 'Title ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'data-parsley-errors-container' => '#parsleyGender',
                    'data-parsley-required-message' => "Gender is required.",
                ),
                'disabled' => 'disabled',
                'help' => 'User title',
                'override_col_size' => 'col-sm-7',
                'parsley_error_container' => 'parsleyGender'
            ))

            ->add('firstName', 'text', array(
                'label' => 'First name ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '2',
                    'data-parsley-errors-container' => '#parsleyFirstName',
                    'data-parsley-required-message' => "First name is required."
                ),
                'disabled' => 'disabled',
                'help' => 'First name',
                'override_col_size' => 'col-sm-7',
                'parsley_error_container' => 'parsleyFirstName'
            ))

            ->add('lastName', 'text', array(
                'label' => 'Surname ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '3',
                    'data-parsley-errors-container' => '#parsleyLastName',
                    'data-parsley-required-message' => "Surname is required."
                ),
                'disabled' => 'disabled',
                'help' => 'Surname ',
                'override_col_size' => 'col-sm-7',
                'parsley_error_container' => 'parsleyLastName'
            ))

            ->add('gender', 'entity', array(
                'empty_value' => 'Select gender',
                'class' => 'MlankaTechAppBundle:Gender',
                'label' => 'Gender ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '4',
                    'data-parsley-errors-container' => '#parsleyGender',
                    'data-parsley-required-message' => "Gender is required.",
                    'rowspan' => 5
                ),
                'disabled' => 'disabled',
                'help' => 'User gender',
                'override_col_size' => 'col-sm-7',
                'parsley_error_container' => 'parsleyGender'
            ))
            ->add('group', 'entity', array(
                'empty_value' => 'Select a role',
                'class' => 'MlankaTechAppBundle:UserGroup',
                'label' => 'Permission ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '5',
                    'data-parsley-errors-container' => '#parsleyGroup',
                    'data-parsley-required-message' => "Security access is required."
                ),
                'disabled' => 'disabled',
                'help' => 'Security access',
                'override_col_size' => 'col-sm-7',
                'parsley_error_container' => 'parsleyGroup'

            ))

        ;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'UserShowType';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MlankaTech\AppBundle\Entity\User',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MlankaTech\AppBundle\Entity\User',
        ));
    }
}