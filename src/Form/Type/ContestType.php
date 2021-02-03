<?php

namespace App\Form\Type;

use App\Entity\Contest;
use App\Entity\QuestionAnswer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('participant', ContestParticipantType::class);

        if($options['type'] === Contest::TYPE_RADIO && $options['questionId'] !== null){
            $builder->add('answer', AnswerRadioButtonType::class, [
                'questionId' => $options['questionId']
            ]);
        }

        $builder
            ->add('acceptance', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Bitte bestätigen Sie die Datenschutzbestimmungen'
                    ])
                ]
            ])
            ->add('newsletter', CheckboxType::class, [
                'mapped' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Teilnehmen'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));

        $resolver->setRequired('type');
        $resolver->setAllowedTypes('type', array('int'));

        $resolver->setRequired('questionId');
        $resolver->setAllowedTypes('questionId', array('null', 'string'));
    }

    public function getBlockPrefix()
    {
        return 'contest_type';
    }
}
