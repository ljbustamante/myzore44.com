<?php
namespace App\Form\Type\Admin;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;
 
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('username', TextType::class, ['label' => 'Nombre de usuario'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('firstName', TextType::class, ['label' => 'Nombres', 'required' => false])
            ->add('lastName', TextType::class, ['label' => 'Apellidos', 'required' => false])
            ->add('enabled', CheckboxType::class, ['label' => 'Activo', 'required' => false])
            ->add('actions', ActionsType::class, ['mapped' => false, 'label' => false, 'required' => false]);
        
        if(!$entity->getId()){
            $builder
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Su clave debe ser idéntica a la ingresada anteriormente.',
                    'first_options'  => array('label' => 'Clave'),
                    'second_options' => array('label' => 'Repetir clave'), 
                    'required' => true
                ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
 
    public function getName()
    {
        return 'admin_user';
    }
}

?>