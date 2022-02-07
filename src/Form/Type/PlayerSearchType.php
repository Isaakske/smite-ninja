<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Form\Data\PlayerSearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('playerName', TextType::class, [
            'label' => 'player_search.player_name',
            'label_attr' => [
                'class' => 'form-label',
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlayerSearchData::class,
        ]);
    }
}
