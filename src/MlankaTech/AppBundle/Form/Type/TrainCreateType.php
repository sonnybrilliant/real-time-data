<?php

namespace MlankaTech\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * MlankaTech\AppBundle\Form\Type\TrainCreateType
 *
 * @DI\Service("mlanka_tech_app.form.type.train.create")
 * @DI\Tag("form.type", attributes = {"alias" = "TrainCreateType"})
 * @author Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Form\User
 * @version 0.0.1
 */
class TrainCreateType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unit', 'text', array(
                'label' => 'Name ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '1',
                    'data-parsley-errors-container' => '#parsleyName',
                    'data-parsley-required-message' => 'Train name is required.',
                ),
                'help' => 'Train name',
                'parsley_error_container' => 'parsleyName',
            ))

            ->add('type', 'entity', array(
                'placeholder' => 'Select type',
                'class' => 'MlankaTechAppBundle:TrainType',
                'label' => 'Type ',
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '2',
                    'data-parsley-errors-container' => '#parsleyType',
                    'data-parsley-required-message' => 'Type is required.',
                ),
                'help' => 'Train type',
                'parsley_error_container' => 'parsleyType',
            ))

            ->add('status', 'entity', array(
                'placeholder' => 'Select status',
                'class' => 'MlankaTechAppBundle:Status',
                'label' => 'Status ',
                'query_builder' => function (EntityRepository $er) {
                    $codes = array(2,1,30,280,290,310,320,330);
                    return $er->createQueryBuilder('s')
                        ->andWhere('s.code IN (:codes)')
                        ->setParameter('codes',$codes);
                },
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '3',
                    'data-parsley-errors-container' => '#parsleyStatus',
                    'data-parsley-required-message' => 'Status is required.',
                ),
                'help' => 'Train status',
                'parsley_error_container' => 'parsleyStatus',
            ))

            ->add('motorcoaches', 'entity', array(
                'placeholder' => 'Assign motor coaches',
                'class' => 'MlankaTechAppBundle:MotorCoach',
                'label' => 'Motor coaches ',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.assigned =:assigned ')
                        ->setParameter('assigned',false);
                },
                'attr' => array(
                    'class' => 'form-control',
                    'tabindex' => '4',
                    'data-parsley-errors-container' => '#parsleyMotorCoaches',
                    'data-parsley-required-message' => 'Motor coaches are required.',
                ),
                'help' => 'Assign motor coaches',
                'parsley_error_container' => 'parsleyMotorCoaches',
            ));

    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'TrainCreateType';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MlankaTech\AppBundle\Entity\Train',
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MlankaTech\AppBundle\Entity\Train',
        ));
    }
}