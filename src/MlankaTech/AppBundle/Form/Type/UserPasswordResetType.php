<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * ResetPasswordType.
 *
 * @DI\Service("mlanka_tech_app.form.type.user.reset.password")
 * @DI\Tag("form.type", attributes = {"alias" = "UserPasswordResetType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class UserPasswordResetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('password', 'repeated', array(
                'first_options' => array('label' => 'New password', 'attr' => array('class' => 'form-control')),
                'second_options' => array('label' => 'Confirm new Password', 'attr' => array('class' => 'form-control')),
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
        return 'UserPasswordResetType';
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
            'validation_groups' => array('forgot_password'),
        ));
    }
}
