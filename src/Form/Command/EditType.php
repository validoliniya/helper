<?php

namespace App\Form\Command;

use App\Entity\Command\Command;
use App\Entity\Command\CommandSection;
use App\Repository\Command\CommandSectionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    private CommandSectionRepository $commandSectionRepository;

    public function __construct(CommandSectionRepository $commandSectionRepository)
    {
        $this->commandSectionRepository = $commandSectionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $section = $this->commandSectionRepository->findOneById($options['section']);
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
                'class' => CommandSection::class,
                'data'  => $section
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
            'section'      => null,
            'data_class'   => Command::class,
            'is_immutable' => true
        ]);
    }
}
