<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', SearchType::class, [
                'label' => false,
                'attr' => ['class' => 'input-search', 'placeholder' => 'Item name'],
            ])
            ->add('type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Skins' => 'skins',
                    'Cards' => 'cards',
                    'Titles' => 'titles',
                    'Sprays' => 'sprays',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'search-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
