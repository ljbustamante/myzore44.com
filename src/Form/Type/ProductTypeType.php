<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\ProductType;
use App\Entity\ProductAttribute;
use App\Form\Type\ActionsType;

class ProductTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productType', TextType::class, ['label' => 'Tipo de producto'])
            ->add('productAttributes', EntityType::class, 
                  array('label' => 'Atributos de producto',
                        'by_reference' => true, 
                        'multiple' => true, 
                        'expanded' => true, 
                        'class' => ProductAttribute::class, 
                        'placeholder' => 'Seleccione los atributos'
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
            'data_class' => ProductType::class,
        ]);
    }
}