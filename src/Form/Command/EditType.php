<?php

namespace App\Form\Command;

use App\Entity\Command\Command;
use App\Entity\Command\CommandSection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('is_immutable', ChoiceType::class, [
                'choices' => [
                    'yes' => true,
                    'no'  => false
                ]
            ])
            ->add('section', EntityType::class, [
                'label' => 'Section',
                'class' => CommandSection::class
            ])
            ->add('template', TextType::class, [
                'empty_data' => ''
            ])
            ->add('example', TextType::class)
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'   => Command::class,
            'is_immutable' => true
        ]);
    }
}
