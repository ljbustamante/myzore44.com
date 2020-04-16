<?php
namespace App\Form\Type\Admin\CatalogueProduct;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use App\Entity\CatalogueProduct;
use App\Entity\Product;
use App\Form\Type\Admin\ActionsType;
use App\Form\Type\Admin\CatalogueProduct\CatalogueProductGroupAttributeValueType;

class CatalogueProductGroupAttributeValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('catalogueProductGroupAttributeValues', CollectionType::class, 
                  ['entry_type' => CatalogueProductGroupAttributeValueType::class, 
                   'entry_options' => ['productObj' => $entity->getProduct()],
                   'allow_add' => true, 
                   'allow_delete' => true, 
                   'required' => false,
                   'label' => 'Valores del Atributo', 
                   'by_reference' => false, 
                   'delete_empty' => true
                  ]
            )
            ->add('save_edit', SubmitType::class, ['label' => 'Guardar y editar', 'attr' => ['class' => 'btn btn-success pull-left margin']])
            ->add('save_list', SubmitType::class, ['label' => 'Guardar y listar', 'attr' => ['class' => 'btn btn-success pull-left margin']])
            ->add('cancel', ButtonType::class, ['label' => 'Cancelar', 'attr' => ['class' => 'btn btn-danger pull-left margin']]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CatalogueProduct::class,
        ]);
    }
}