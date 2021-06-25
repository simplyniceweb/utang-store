<?php

namespace App\Forms;

use App\Entity\Inventory;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('wholesale_price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'step' => '0.01',
                    'value' => 0
                ]
            ])
            ->add('store_price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'step' => '0.01'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}