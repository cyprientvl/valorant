<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateLocker extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'input-search', 'placeholder' => 'Creer']
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Is Public',
                'required' => false, 
                'attr' => ['class' => 'checkbox-class'],
            ]);            
    }
}
