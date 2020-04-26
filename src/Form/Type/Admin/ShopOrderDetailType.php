<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\ShopOrderDetail;
use App\Entity\ProductGroupAttributeValue;
use App\Entity\Product;

class ShopOrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, 
                  ['label' => 'Producto',
                   'by_reference' => true, 
                   'multiple' => false, 
                   'expanded' => false, 
                   'class' => Product::class, 
                   'placeholder' => 'Seleccione el producto'
                  ]
                 )
            ->add('productGroupAttributeValue', EntityType::class, 
                  ['label' => 'Grupo de Atributos',
                   'by_reference' => true, 
                   'multiple' => false, 
                   'expanded' => false, 
                   'class' => ProductGroupAttributeValue::class, 
                   'placeholder' => 'Seleccione el grupo de atributos', 
                   'choice_attr' => function($group, $key, $index) {
                       return ['product_id' => $group->getProduct()->getId()];
                   }
                  ]
                 )
            ->add('quantity', TextType::class, ['label' => 'Cantidad', 'required' => false])
            ->add('unitaryPrice', TextType::class, ['label' => 'Precio unitario', 'required' => false])
            ->add('totalPrice', TextType::class, ['label' => 'Precio total', 'required' => false]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShopOrderDetail::class,
        ]);
    }
}