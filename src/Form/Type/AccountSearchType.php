<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Form\Data\AccountSearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('accountName', TextType::class, [
            'label' => 'account_search.player_name',
            'label_attr' => [
                'class' => 'form-label',
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountSearchData::class,
        ]);
    }
}
