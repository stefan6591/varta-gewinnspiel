<?php

namespace App\Form\Admin\Type;

use App\Entity\Contest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('startDate', TextType::class)
            ->add('endDate', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => Contest::$types,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('question', QuestionType::class, [
                'label' => false
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contest::class,
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();

                if (Contest::TYPE_RADIO == $data->getType()) {
                    return array('Default', 'radio');
                }
                return ['Default'];
            },
        ));
    }

    public function getBlockPrefix()
    {
        return 'contest_admin_type';
    }
}
