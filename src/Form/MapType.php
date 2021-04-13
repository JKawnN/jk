<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('worldRecord', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/(^\d?\d?\d[:]\d{2}[.]\d{3}$)/i',
                        'message' => 'Le temps doit être au format \'00:00.000\' ',
                    ])
                ],

                'data' => '00:00.000',
            ])
            ->add('category', EntityType::class, [

                'class' => Category::class,

                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter une map'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}