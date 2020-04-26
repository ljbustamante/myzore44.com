<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Product;
use App\Entity\Genre;
use App\Entity\Provider;
use App\Entity\ProductType as BaseType;
use App\Form\Type\Admin\ActionsType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        $builder
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('code', TextType::class, ['label' => 'Código'])
            ->add('longDescription', TextType::class, ['label' => 'Descripción'])
            ->add('productType', EntityType::class, 
                  array('label' => 'Tipo de producto',
                        'by_reference' => true, 
                        'multiple' => false, 
                        'expanded' => true, 
                        'class' => BaseType::class, 
                        'placeholder' => 'Seleccione el tipo de producto'
                       )
                 )
            ->add('genre', EntityType::class, 
                 array('label' => 'Género',
                       'by_reference' => true, 
                       'multiple' => false, 
                       'expanded' => true, 
                       'class' => Genre::class, 
                       'placeholder' => 'Seleccione el género'
                      )
                )
            ->add('providers', EntityType::class, 
                array('label' => 'Proveedores',
                      'by_reference' => true, 
                      'multiple' => true, 
                      'expanded' => true, 
                      'class' => Provider::class
                     )
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
            'data_class' => Product::class,
        ]);
    }
}