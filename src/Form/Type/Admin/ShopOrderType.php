<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\ShopOrder;
use App\Entity\ShopOrderDetail;
use App\Entity\Provider;
use App\Form\Type\Admin\ActionsType;
use App\Form\Type\Admin\ShopOrderDetailType;


class ShopOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, ['label' => 'Código'])
            ->add('date', DateType::class, ['label' => 'Fecha', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'placeholder' => 'dd/mm/yyyy'])
            ->add('deliveryDate', DateType::class, ['label' => 'Fecha de entrega', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'placeholder' => 'dd/mm/yyyy'])
            ->add('provider', EntityType::class, 
                  ['label' => 'Proveedores',
                   'by_reference' => true, 
                   'multiple' => false, 
                   'expanded' => false, 
                   'class' => Provider::class
                  ]
                 )
            ->add('shopOrderDetails', CollectionType::class, 
                  ['entry_type' => ShopOrderDetailType::class, 
                   'allow_add' => true, 
                   'allow_delete' => true, 
                   'required' => false,
                   'label' => 'Cacterísticas de producto', 
                   'by_reference' => false, 
                   'delete_empty' => function(ShopOrderDetail $value){ return empty($value->getProduct()); }
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
            'data_class' => ShopOrder::class,
        ]);
    }
}