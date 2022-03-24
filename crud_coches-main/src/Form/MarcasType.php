<?php

namespace App\Form;

use App\Entity\Marcas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarcasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre',TextType::class)
            ->add('descripcion',TextType::class)
            ->add('activo',CheckboxType::class,array('required' => false))
            ->add('Crear',SubmitType::class,array('label'=> $options['submit']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'submit' => 'Añadir',
        ]);
    }
}
