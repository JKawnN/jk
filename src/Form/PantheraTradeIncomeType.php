<?php

namespace App\Form;

use App\Entity\PantheraTradeIncome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PantheraTradeIncomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('checkbox', ChoiceType::class, [
                'label'    => 'Type',
                'required' => true,
                'choices' => [
                    'Gains' => 0,
                    'Pertes' => 1,
                ]
            ])
            ->add('date',DateType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
