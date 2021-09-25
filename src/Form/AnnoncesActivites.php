<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Equipements;
use App\Entity\Loisirs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnoncesActivites extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('loisirs', EntityType::class, [
            'by_reference' => false,
            'class' => Loisirs::class,
            'expanded' => true,
            'multiple' => true,
            'choice_attr' => array('checked'=>false),
            'choice_label' => 'nom',
        ])
        ->add('description', TextareaType::class )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
