<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * UserChangePasswordType.
 *
 * @DI\Service("mlanka_tech_app.form.type.user.change.password")
 * @DI\Tag("form.type", attributes = {"alias" = "UserChangePasswordType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class UserChangePasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', 'password', array(
                'label' => 'Current password ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'data-parsley-errors-container' => '#parsleyOldPassword',
                    'data-parsley-required-message' => 'Current password required.',
                ),
                'help' => 'Provide your current password',
                'parsley_error_container' => 'parsleyOldPassword'
            ))
            ->add('newPassword', 'repeated', array(
                'first_options' => array('label' => 'New password', 'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '2',
                    'data-parsley-errors-container' => '#parsleyNewPassword',
                    'data-parsley-required-message' => 'New password required.',
                )),
                'second_options' => array('label' => 'Confirm new Password', 'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '3',
                    'data-parsley-errors-container' => '#parsleyConfirmNewPassword',
                    'data-parsley-required-message' => 'Confirm new password required.',
                )),
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return 'UserChangePasswordType';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MlankaTech\AppBundle\Form\Model\UserChangePassword',

        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MlankaTech\AppBundle\Form\Model\UserChangePassword',
            'validation_groups' => array('change_password'),
        ));
    }
}
