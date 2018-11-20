<?php

namespace App\Form\Admin\Type;

use App\Entity\Contest;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('answers', CollectionType::class, array(
                'entry_type' => QuestionAnswerType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Question::class,
        ));

//        $resolver->setRequired('type');
//        $resolver->setAllowedTypes('type', array('int'));
    }

    public function getBlockPrefix()
    {
        return 'question_admin_type';
    }
}
