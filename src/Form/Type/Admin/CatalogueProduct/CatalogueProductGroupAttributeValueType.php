<?php
namespace App\Form\Type\Admin\CatalogueProduct;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\CatalogueProductGroupAttributeValue;
use App\Entity\ProductGroupAttributeValue;

class CatalogueProductGroupAttributeValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('productGroupAttributeValue', EntityType::class, 
                  ['label' => 'Producto',
                   'by_reference' => true, 
                   'multiple' => false, 
                   'expanded' => false, 
                   'class' => ProductGroupAttributeValue::class, 
                   'placeholder' => 'Seleccione el grupo de atributos del producto', 
                   'choices' => $options['productObj']->getProductGroupAttributesValue()
                  ]
                 )
            ->add('physicalStock', TextType::class, ['label' => 'Stock Físico', 'required' => false])
            ->add('allowedStock', TextType::class, ['label' => 'Stock disponible', 'required' => false])
            ->add('price', TextType::class, ['label' => 'Precio', 'required' => false]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CatalogueProductGroupAttributeValue::class,
            'productObj' => null
        ]);
    }
}