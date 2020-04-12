<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Campaign;
use App\Form\Type\Admin\ActionsType;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nombre de Campaña'])
            ->add('startDate', DateType::class, ['label' => 'Inicio', 'widget' => 'choice'])
            ->add('endDate', DateType::class, ['label' => 'Final', 'widget' => 'choice'])
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
            'data_class' => Campaign::class,
        ]);
    }
}