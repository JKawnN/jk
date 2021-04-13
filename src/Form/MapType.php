<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('worldRecord', TextType::class)
            ->add('category')
            ->add('submit', SubmitType::class)
        ;

        $builder
            ->get('worldRecord')
            ->addModelTransformer(new CallbackTransformer(
                function ($worldRecordFloat) {
                    // transform the array to a string
                    //dd($worldRecordFloat);
                    if ($worldRecordFloat) {
                        return $formatedTime;
                    } else {
                        return '00:00.000';
                    }
                },
                function ($worldRecordString) {
                    // transform the string back to an array
                    $formatedTime = (strstr($worldRecordString, ':', true) * 60) +  str_replace(':', '', (strstr($worldRecordString, ':')));
                    return $formatedTime;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Map::class,
        ]);
    }
}
