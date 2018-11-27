<?php

namespace App\Form\Type;

use App\Entity\ContestParticipant;
use App\Entity\QuestionAnswer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnswerRadioButtonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('radio', EntityType::class, [
                'mapped' => false,
                'class' => QuestionAnswer::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('qa')
                        ->where('qa.question = :question')
                        ->setParameter('question', $options['questionId']);
                },
                'choice_label' => 'title',
                'expanded' => true,
                'multiple' => false,
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Bitte wählen Sie eine Antwort aus.'])
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));

        $resolver->setRequired('questionId');
        $resolver->setAllowedTypes('questionId', array('string'));
    }

    public function getBlockPrefix()
    {
        return 'answer_radio_button_type';
    }
}
