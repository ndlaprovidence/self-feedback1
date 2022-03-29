<?php

namespace App\Form;

use App\Entity\ChartChoice;
use Doctrine\DBAL\Types\TextType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChartChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', ChoiceType::class, [
            'choices' => [
                "Barres" => "bar",
                'Lignes'=> "line",
                'Donut' => "doughnut",
                'Polar' => "polarArea",
                'Radar' => "radar",
            ],
            'expanded' => true,
            'multiple' => false,

        ]);
        $builder->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChartChoice::class,
        ]);
    }
}
