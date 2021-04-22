<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Exception\TransformationFailedException;
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
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter une map',
            ])
        ;

        $builder
            ->get('worldRecord')
            ->addModelTransformer(new CallbackTransformer(
                /**
                 * Transform a float into string
                 */
                function ($worldRecordFloat) {
                    return '00:00.000';
                },
                /**
                 * Transform a string into float if the regex returns true
                 */
                function ($worldRecordString) {
                    if (preg_match('/^\d?\d?\d[:]\d{2}[.]\d{3}$/im', $worldRecordString)) {
                        $formatedTime = (strstr($worldRecordString, ':', true) * 60) +  str_replace(':', '', (strstr($worldRecordString, ':')));
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
            'data_class' => Map::class,
        ]);
    }
}
