<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurment;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class MeasurmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class,)
            ->add('Temperature', NumberType::class,[
                'attr' => ['placeholder' => 'Enter temperature',
                'min'=>-273,
                'max'=>60],
                'invalid_message' => 'The temperature field is required.',
                'constraints' => [
                    new Range([
                        'min'=>-273,
                        'max'=>60,
                        'notInRangeMessage'=>'The temperature must be between -273 and 60.',]),
                ],])
            ->add('Atmospheric_pressure', NumberType::class,[
                'attr' => ['placeholder' => 'Enter atmospheric pressure',
                    'min'=>300,
                    'max'=>1200],
                'invalid_message' => 'The atmospheric pressure field is required.',
                'constraints' => [
                    new Range([
                        'min'=>300,
                        'max'=>1200,
                        'notInRangeMessage'=>'The longitude must be between 300 and 1200.',]),
                ],
            ])
            ->add('cloudiness')
            ->add('Wind', ChoiceType::class, [
                'choices' => [
                    'North' => 'N',
                    'South' => 'S',
                    'East' => 'E',
                    'West' => 'W',
                    'North west' => 'NW',
                    'South west' => 'SW',
                    'North East' => 'NE',
                    'South East' => 'SE',
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurment::class,
        ]);
    }
}
