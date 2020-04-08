<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Catalogue;
use App\Entity\Campaign;
use App\Form\Type\ActionsType;

class CatalogueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nombre de Catálogo'])
            ->add('campaign', EntityType::class, 
                  array('label' => 'Campaña',
                        'by_reference' => true, 
                        'multiple' => false, 
                        'expanded' => true, 
                        'class' => Campaign::class, 
                        'placeholder' => 'Seleccione la campaña'
                       )
                 )
            ->add('startDate', DateType::class, 
                ['label' => 'Inicio', 
                 'widget' => 'single_text', 
                 'format' => 'dd-MM-yyyy', 
                 'placeholder' => 'dd-mm-yyyy', 
                 'required' => false
                ]
            )
            ->add('endDate', DateType::class, 
                ['label' => 'Final', 
                 'widget' => 'single_text', 
                 'format' => 'dd-MM-yyyy', 
                 'placeholder' => 'dd-mm-yyyy', 
                 'required' => false
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
            'data_class' => Catalogue::class,
        ]);
    }
}