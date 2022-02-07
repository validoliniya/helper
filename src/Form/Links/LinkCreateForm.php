<?php

namespace App\Form\Links;

use App\Entity\Links\Link;
use App\Entity\Links\LinkSection;
use App\Repository\Links\LinkSectionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkCreateForm extends AbstractType
{
    private LinkSectionRepository $linkSectionRepository;

    public function __construct(LinkSectionRepository $linkSectionRepository)
    {
        $this->linkSectionRepository = $linkSectionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $section = $this->linkSectionRepository->findOneById($options['section']);
        $builder
            ->add('name', TextType::class)
            ->add('href', TextType::class)
            ->add('section', EntityType::class, [
                'label' => 'Section',
                'class' => LinkSection::class,
                'data'  => $section
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'section'    => null,
            'data_class' => Link::class,
        ]);
    }
}
