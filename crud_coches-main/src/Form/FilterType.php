<?php

namespace App\Form;


use App\Entity\Marcas;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // busqueda campos: Campos: modelo, año, activo y marca.

        $builder
            ->setMethod('GET')
            ->add('modelo',TextType::class,array('required'=>false))
            ->add('ano',IntegerType::class,array('required'=>false))
            ->add('activo',CheckboxType::class,array('required'=>false))
            ->add('marca',EntityType::class,array('class'=>Marcas::class,'choice_label'=> 'nombre'))

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