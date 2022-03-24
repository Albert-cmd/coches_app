<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterMarcasType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // busqueda campos: Campos: modelo, año, activo y marca.

        $builder
            ->add('nombre',TextType::class,array('required'=>false))
            ->add('activo',CheckboxType::class,array('required'=>false))
            ->add('Buscar',SubmitType::class,array('label'=> $options['submit']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'submit' => 'Buscar',
        ]);
    }

}