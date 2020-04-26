<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Depot;
use App\Entity\Shelf;
use App\Form\Type\Admin\ActionsType;
use App\Form\Type\Admin\ShelfType;


class DepotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depot', TextType::class, ['label' => 'Almacén'])
            ->add('shelfs', CollectionType::class, 
                ['entry_type' => ShelfType::class, 
                 'allow_add' => true, 
                 'allow_delete' => true, 
                 'required' => false,
                 'label' => 'Anaqueles', 
                 'by_reference' => false, 
                 'delete_empty' => function(Shelf $value){ return empty($value->getShelf()); }
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
            'data_class' => Depot::class,
        ]);
    }
}