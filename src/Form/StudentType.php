<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('note_gout', ChoiceType::class, [
            'choices' => [
                " " => 1,
                "  " => 2,
                "  " => 3,
                "   " => 4,
                "    " => 5,
            ],
            'choice_attr' => [
                '1' => ['id' => '1'],
                '2' => ['id' => '2'],
                '3' => ['id' => '3'],
                '4' => ['id' => '4'],
                '5' => ['id' => '5'],
                ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('note_chaleur', ChoiceType::class, [
            'choices' => [
                " " => 1,
                "  " => 2,
                "  " => 3,
                "   " => 4,
                "    " => 5,
            ],
            'choice_attr' => [
                '1' => ['id' => '1'],
                '2' => ['id' => '2'],
                '3' => ['id' => '3'],
                '4' => ['id' => '4'],
                '5' => ['id' => '5'],
                ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('note_hygiene', ChoiceType::class, [
            'choices' => [
                " " => 1,
                "  " => 2,
                "  " => 3,
                "   " => 4,
                "    " => 5,
            ],
            'choice_attr' => [
                '1' => ['id' => '1'],
                '2' => ['id' => '2'],
                '3' => ['id' => '3'],
                '4' => ['id' => '4'],
                '5' => ['id' => '5'],
                ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('note_acceuil', ChoiceType::class, [
            'choices' => [
                " " => 1,
                "  " => 2,
                "  " => 3,
                "   " => 4,
                "    " => 5,
            ],
            'choice_attr' => [
                '1' => ['id' => '1'],
                '2' => ['id' => '2'],
                '3' => ['id' => '3'],
                '4' => ['id' => '4'],
                '5' => ['id' => '5'],
                ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('note_quantite', ChoiceType::class, [
            'choices' => [
                " " => 1,
                "  " => 2,
                "  " => 3,
                "   " => 4,
                "    " => 5,
            ],
            'choice_attr' => [
                '1' => ['id' => '1'],
                '2' => ['id' => '2'],
                '3' => ['id' => '3'],
                '4' => ['id' => '4'],
                '5' => ['id' => '5'],
                ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('note_diversite', ChoiceType::class, [
            'choices' => [
                " " => 1,
                "  " => 2,
                "  " => 3,
                "   " => 4,
                "    " => 5,
            ],
            'choice_attr' => [
                '1' => ['id' => '1'],
                '2' => ['id' => '2'],
                '3' => ['id' => '3'],
                '4' => ['id' => '4'],
                '5' => ['id' => '5'],
                ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('note_commentaire', TextareaType::class, [
            'attr' => [
                'rows' => '10',
                'cols' => '40',
                // 'name' => 'note_commentaire'
            ],
        ]);

        $builder->add('classe', EntityType::class, [
            // looks for choices from this entity
            'class' => Classes::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'classe_libelle',

            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
        ]);

        $builder->add('envoyer', SubmitType::class, [
            'attr' => ['class' => 'login_inputs'],
            'attr' => ['id' => 'btn5'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
