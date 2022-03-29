<?php

namespace App\Form;

use App\Entity\StudentCritere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentCritereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('noteChaleur')
            ->add('noteGout')
            ->add('notequantite')
            ->add('noteacceuil')
            ->add('notediversite')
            ->add('notehygiene')
            ->add('idStudent')
            ->add('idCritere')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentCritere::class,
        ]);
    }
}
