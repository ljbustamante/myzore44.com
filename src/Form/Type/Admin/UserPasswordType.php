<?php
namespace App\Form\Type\Admin;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;
 
class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Su clave debe ser idéntica a la ingresada anteriormente.',
                    'first_options'  => array('label' => 'Nueva clave'),
                    'second_options' => array('label' => 'Repetir clave'), 
                    'required' => true
                ))
            ->add('save_edit', SubmitType::class, ['label' => 'Actualizar', 'attr' => ['class' => 'btn btn-success pull-left margin']])
            ->add('cancel', ButtonType::class, ['label' => 'Cancelar', 'attr' => ['class' => 'btn btn-info pull-left margin']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
 
    public function getName()
    {
        return 'admin_user_password';
    }
}

?>