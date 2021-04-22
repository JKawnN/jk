<?php

namespace App\Form;

use App\Entity\TmStats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TmStatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('top')
            ->add('record', TextType::class)
            ->add('map')
        ;

        $builder
        ->get('record')
        ->addModelTransformer(new CallbackTransformer(
            /**
             * Transform a float into string
             */
            function ($recordFloat) {
                if ($recordFloat) {
                    return $formatedTime;
                } else {
                    return '00:00.000';
                }
            },
            /**
             * Transform a string into float if the regex returns true
             */
            function ($recordString) {
                if (preg_match('/^\d?\d?\d[:]\d{2}[.]\d{3}$/im', $recordString)) {
                    $formatedTime = (strstr($recordString, ':', true) * 60) +  str_replace(':', '', (strstr($recordString, ':')));
                    return $formatedTime;
                } else {
                    throw new TransformationFailedException();
                }
            }
        ))
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TmStats::class,
        ]);
    }
}
