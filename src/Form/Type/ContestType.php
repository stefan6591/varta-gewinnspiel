<?php

namespace App\Form\Type;

use App\Entity\Contest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('participant', ContestParticipantType::class);

        if($options['type'] === Contest::TYPE_DEFAULT){

        }

        $builder
            ->add('newsletter', CheckboxType::class, [
                'mapped' => false
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));

        $resolver->setRequired('type');
        $resolver->setAllowedTypes('type', array('int'));
    }

    public function getBlockPrefix()
    {
        return 'contest_type';
    }
}
