<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class MeetingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name')
        ->add('startTime', DateTimeType::class, array(
                'label'     => 'Start Time',
                'html5'     => false,
                'required'  => true,
                'widget'    => 'single_text',
                'attr'      => array(
                                    'class' => 'datepicker',
                                    'type'  => 'text'
                                )
            ))
        ->add('endTime', DateTimeType::class, array(
                'label'     => 'End Time',
                'html5'     => false,
                'required'  => true,
                'widget'    => 'single_text',
                'attr'      => array(
                                    'class' => 'datepicker',
                                    'type'  => 'text'
                                )
        ))
        ->add('location')
        ->add('description')
        ->add('participants', EntityType::class, array(
                'class' => 'AppBundle:Person',
                'choice_label' => 'name',
                'mapped' => false
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Meeting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_meeting';
    }


}
