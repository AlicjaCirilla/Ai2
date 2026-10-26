<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('City', null,[
                'attr' => ['placeholder' => 'Enter city name'],
            ])
            ->add('Country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'GE',
                    'France' => 'FR',
                    'Spain' => 'ES',
                    'Italy' => 'IT',
                    'United Kingdom' => 'UK',
                    'United States' => 'US',
                ],
            ])
            ->add('Latitude', NumberType::class, [
                'attr' => ['placeholder' => 'Enter latitude',
                    'min'=>-90,
                    'max'=>90],
                'invalid_message' => 'The latitude field is required.',
                'constraints' => [
                    new Range([
                        'min'=>-90,
                        'max'=>90,
                        'notInRangeMessage'=>'The latitude must be between -90 and 90.',]),
                ],
            ])
            ->add('Longitude',NumberType::class,[
                'attr' => ['placeholder' => 'Enter longitude',
                    'min'=>-180,
                    'max'=>180],
                'invalid_message' => 'The longitude field is required.',
                'constraints' => [
                    new Range([
                        'min'=>-180,
                        'max'=>180,
                        'notInRangeMessage'=>'The longitude must be between -90 and 90.',]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
