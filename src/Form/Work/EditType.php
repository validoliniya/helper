<?php

namespace App\Form\Work;

use App\Entity\Work\Task;
use App\Entity\Work\Timer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task', EntityType::class, [
                'label' => 'Task',
                'class' => Task::class
            ])
            ->add('temp_data', \DateTime::class,[
                'empty_data' => ''
            ])
            ->add('time', IntegerType::class)
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'   => Timer::class
        ]);
    }
}
