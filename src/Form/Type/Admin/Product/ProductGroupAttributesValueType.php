<?php
namespace App\Form\Type\Admin\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Product;
use App\Form\Type\Admin\Product\ProductAttributeValuesType;
use App\Form\Type\Admin\ActionsType;

class ProductGroupAttributesValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        $builder
            ->add('productGroupAttributesValue', CollectionType::class, 
                ['entry_type' => ProductAttributeValuesType::class, 
                 'entry_options' => ['productObj' => $entity],
                 'allow_add' => true, 
                 'allow_delete' => true, 
                 'required' => false,
                 'label' => 'Valores del Atributo', 
                 'by_reference' => false, 
                 'delete_empty' => true
                ]
            )
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