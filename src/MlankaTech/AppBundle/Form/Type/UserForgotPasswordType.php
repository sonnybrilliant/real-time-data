<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * UserForgotPasswordType.
 *
 * @DI\Service("mlanka_tech_app.form.type.user.forgot.password")
 * @DI\Tag("form.type", attributes = {"alias" = "UserForgotPasswordType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class UserForgotPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'label' => 'Email address ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'data-parsley-errors-container' => '#parsleyEmailAddress',
                    'data-parsley-required-message' => 'Email address is required.',
                    'data-parsley-type' => 'email',
                    'data-parsley-trigger' => 'change',
                    'placeholder' => 'Your email address',
                ),
                'help' => 'User email address',
                'parsley_error_container' => 'parsleyEmailAddress',
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
        return 'UserForgotPasswordType';
    }
}
