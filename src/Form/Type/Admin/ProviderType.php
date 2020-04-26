<?php
namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Provider;
use App\Form\Type\Admin\ActionsType;

class ProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        $builder
            ->add('provider', TextType::class, ['label' => 'Proveedor'])
            ->add('ruc', TextType::class, ['label' => 'R.U.C.', 'required' => false])
            ->add('comercialName', TextType::class, ['label' => 'Nombre comercial', 'required' => false])
            ->add('socialReason', TextType::class, ['label' => 'Razón social', 'required' => false])
            ->add('telephone', TextType::class, ['label' => 'Teléfono', 'required' => false])
            ->add('email', TextType::class, ['label' => 'Email', 'required' => false])
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
            'data_class' => Provider::class,
        ]);
    }
}