<?php
namespace App\Form\Type\Admin\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\ProductGroupAttributeValue;
use App\Entity\ProductAttributeValue;

class ProductAttributeValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        # dump($entity);
        $builder
            ->add('productAttributeValues', CollectionType::class, 
                ['entry_type' => EntityType::class, 
                 'entry_options' => 
                    ['class' =>  ProductAttributeValue::class, 
                     'multiple' => false, 
                     'expanded' => false, 
                     'label' => 'Valor del atributo', 
                     'group_by' => function($attributeValue){
                     return $attributeValue->getProductAttribute()->getProductAttribute();
                     },
                     'choice_attr' => function($attributeValue) {
                         return ['product_attribute_id' => $attributeValue->getProductAttribute()->getId()];
                     },
                     'placeholder' => 'Seleccione el valor de atributo', 
                     'choices' => array_reduce($options['productObj']->getProductType()->getProductAttributes()->toArray(), 
                                               function($c, $i){ 
                                                   return array_merge($c, $i->getProductAttributeValues()->toArray()); 
                                                }, [])
                    ],
                 'allow_add' => true, 
                 'allow_delete' => true, 
                 'required' => false,
                 'label' => 'Atributos', 
                 'by_reference' => false, 
                 'delete_empty' => true, 
                 'prototype_name' => '__value__', 
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductGroupAttributeValue::class,
            'productObj' => null
        ]);
    }
}