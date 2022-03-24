<?php

namespace App\Form;
use App\Entity\Marcas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Response;


class CochesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

                ->add('modelo',TextType:: class)
                ->add('descripcion',TextType:: class)
                ->add('marca',EntityType::class, array('class' => Marcas::class,
                'choice_label' => function ($marcas){
                                    return $marcas->getNombre();},
                    'required' => false))
                ->add('propietario',TextType::class,array('required'=>true,'attr'=>[
                    'maxlength' => 100, 'pattern' => '^[a-zA-Z0–9+_.-]+@[a-zA-Z0–9.-]+$'
                ]))
                ->add('ano',IntegerType::class,array('required' => false,

                ))
                ->add('imagen',FileType::class,array(
                    'label' => 'Image',
                    'mapped'=> false,
                    'required' => false,
                    'constraints' => [

                    ]
                ))
                ->add('activo',CheckboxType::class,array('required' => false))
            ->add('Crear',SubmitType::class,array('label'=> $options['submit']))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'submit' => 'Añadir',
        ]);
    }

}