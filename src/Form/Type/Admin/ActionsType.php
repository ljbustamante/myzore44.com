<?php
namespace App\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
 
class ActionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('save_edit', SubmitType::class, ['label' => 'Guardar y editar', 'attr' => ['class' => 'btn btn-success pull-left margin']])
            ->add('save_new', SubmitType::class, ['label' => 'Guardar y crear nuevo', 'attr' => ['class' => 'btn btn-success pull-left margin']])
            ->add('save_list', SubmitType::class, ['label' => 'Guardar y listar', 'attr' => ['class' => 'btn btn-success pull-left margin']])
            ->add('cancel', ButtonType::class, ['label' => 'Cancelar', 'attr' => ['class' => 'btn btn-danger pull-left margin']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }
 
    public function getName()
    {
        return 'actions';
    }
}

?>