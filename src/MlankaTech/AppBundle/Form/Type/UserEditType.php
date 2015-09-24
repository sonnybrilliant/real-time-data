<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Type\UserEditType
 *
 * @DI\Service("mlanka_tech_app.form.type.user.edit")
 * @DI\Tag("form.type", attributes = {"alias" = "UserEditType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class UserEditType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array(
                'label' => 'First name ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'data-parsley-errors-container' => '#parsleyFirstName',
                    'data-parsley-required-message' => 'First name is required.',
                ),
                'help' => 'First name',
                'parsley_error_container' => 'parsleyFirstName',
            ))

            ->add('lastName', 'text', array(
                'label' => 'Surname ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '2',
                    'data-parsley-errors-container' => '#parsleyLastName',
                    'data-parsley-required-message' => 'Surname is required.',
                ),
                'help' => 'Surname',
                'parsley_error_container' => 'parsleyLastName',
            ))

            ->add('gender', 'entity', array(
                'placeholder' => 'Select gender',
                'class' => 'MlankaTechAppBundle:Gender',
                'label' => 'Gender ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '3',
                    'data-parsley-errors-container' => '#parsleyGender',
                    'data-parsley-required-message' => 'Gender is required.',
                    'rowspan' => 5,
                ),
                'help' => 'Gender',
                'parsley_error_container' => 'parsleyGender',
            ))

            ->add('title', 'entity', array(
                'placeholder' => 'Select title',
                'class' => 'MlankaTechAppBundle:Title',
                'label' => 'Title ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '4',
                    'data-parsley-errors-container' => '#parsleyTitle',
                    'data-parsley-required-message' => 'Title is required.',
                ),
                'help' => 'Title',
                'parsley_error_container' => 'parsleyTitle',
            ))

            ->add('email', 'text', array(
                'label' => 'Email address ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '5',
                    'data-parsley-errors-container' => '#parsleyEmailAddress',
                    'data-parsley-required-message' => 'Email address is required.',
                    'data-parsley-type' => 'email',
                    'data-parsley-trigger' => 'change',
                ),
                'help' => 'Email address',
                'parsley_error_container' => 'parsleyEmailAddress',
                'disabled' => true,
            ));


    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'UserEditType';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MlankaTech\AppBundle\Entity\User',
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MlankaTech\AppBundle\Entity\User',
        ));
    }
}