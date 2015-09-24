<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('group', 'entity', array(
                'class' => 'MlankaTechAppBundle:UserGroup',
                'label' => 'Role ',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'help' => 'Permission',
                'disabled' => true,
            ))

            ->add('firstName', 'text', array(
                'label' => 'First name ',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'help' => 'First name',
                'disabled' => true,
            ))

            ->add('lastName', 'text', array(
                'label' => 'Surname ',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'help' => 'Surname ',
                'disabled' => true,
            ))
            ->add('gender', 'entity', array(
                'class' => 'MlankaTechAppBundle:Gender',
                'label' => 'Gender ',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'help' => 'Gender',
                'disabled' => true,
            ))

            ->add('title', 'entity', array(
                'class' => 'MlankaTechAppBundle:Title',
                'label' => 'Title ',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'help' => 'Title',
                'disabled' => true,
            ))

            ->add('email', 'text', array(
                'label' => 'Email address ',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'help' => 'Email address',
                'disabled' => true,
            ))
            ->add('createdAt', 'datetime', array(
                'label' => 'Created At ',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd  HH:m:s a',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'disabled' => true,
                'help' => 'When was user created',
            ))
            ->add('updatedAt', 'datetime', array(
                'label' => 'Update At ',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd  HH:m:s a',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'disabled' => true,
                'help' => 'When was user last updated',
            ))
            ->add('lastLogin', 'datetime', array(
                'label' => 'Last login At ',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd  HH:m:s a',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'disabled' => true,
                'help' => 'When was user last updated',
            ))
            ->add('createdBy', 'entity', array(
                'class' => 'MlankaTechAppBundle:User',
                'label' => 'Created By ',
                'placeholder' => 'Default System user',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'disabled' => true,
                'help' => 'Who created the user',
            ));

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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MlankaTech\AppBundle\Entity\User',
        ));
    }
}