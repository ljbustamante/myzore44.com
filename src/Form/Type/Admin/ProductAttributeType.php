<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeValue;
use App\Form\Type\Admin\ActionsType;
use App\Form\Type\Admin\ProductAttributeValueType;


class ProductAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productAttribute', TextType::class, ['label' => 'Atributo de producto'])
            ->add('productAttributeValues', CollectionType::class, 
                ['entry_type' => ProductAttributeValueType::class, 
                 'allow_add' => true, 
                 'allow_delete' => true, 
                 'required' => false,
                 'label' => 'Valores del Atributo', 
                 'by_reference' => false, 
                 'delete_empty' => function(ProductAttributeValue $value){ return empty($value->getProductAttributeValue()); }
                ]
            )
            ->add('active', CheckboxType::class, ['label' => 'Activo', 'required' => false])
            ->add('actions', ActionsType::class, 
                  ['mapped' => false, 
                   'label' => false, 
                   'required' => false
                  ]
                 );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductAttribute::class,
        ]);
    }
}