<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\CatalogueProduct;
use App\Entity\Product;
use App\Form\Type\Admin\ActionsType;

class CatalogueProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('product', EntityType::class, 
                  ['label' => 'Producto',
                   'by_reference' => true, 
                   'multiple' => false, 
                   'expanded' => false, 
                   'class' => Product::class, 
                   'placeholder' => 'Seleccione el producto', 
                   'disabled' => ($entity->getId() != null)
                  ]
                 )
            ->add('price', TextType::class, ['label' => 'Precio'])
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
            'data_class' => CatalogueProduct::class,
        ]);
    }
}