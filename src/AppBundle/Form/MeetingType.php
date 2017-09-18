<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
        ->add('participants',  CollectionType::class, array(
                'entry_type'   => PersonType::class,
                'label' => 'Add Participants',
                'entry_options' => array(
                    'label' => ' '
                ),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__person__',
                'by_reference' => false,
                'attr'      => array(
                'class' => "form-pattern-collection",
                )
            ))
        ;
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
