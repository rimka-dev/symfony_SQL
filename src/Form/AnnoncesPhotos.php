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

class AnnoncesPhotos extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('img1', FileType::class, [
            'label'=> 'Ajouter une image',
            'required'=> true
        ])
        ->add('img2', FileType::class, [
            'label'=> 'Ajouter une image',
            'required'=> false
        ])
        ->add('img3',FileType::class, [
            'label'=> 'Ajouter une image',
            'required'=> false
        ])
        ->add('img4',FileType::class, [
            'label'=> 'Ajouter une image',
            'required'=> false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
