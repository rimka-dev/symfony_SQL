<?php

namespace App\Form;
use App\Entity\Equipements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type_logement', ChoiceType::class, [
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison'
                ],
                'multiple'=>true,
                'expanded'=>true,
            ])
            ->add('prix', IntegerType:: class, ['required' => false] )
            ->add('spf_chambre', IntegerType:: class, ['required' => false] )
            ->add('superficie', IntegerType:: class, ['required' => false] )
            ->add('animaux', ChoiceType::class, [
                'choices'=>[
                    'Animaux'=> true
                ],
                'multiple'=>true,
                'expanded'=>true
            ])
            ->add('pref_genre', ChoiceType::class, [
                'choices' => [
                    'Un homme' => 'Un homme',
                    'Une femme' => 'Une femme',
                    'Ca m\'est égal' => 'Ca m\'est égal',
                ],
                'multiple'=>true,
                'expanded'=>true
                
            ] )
            ->add('fumeur',ChoiceType::class, [
                'choices'=>[
                    ' fumeur'=> true
                ],
                'multiple'=>true,
                'expanded'=>true
            ])
            ->add('user',HiddenType::class)
            ->add('equipements', EntityType::class, [
                'by_reference' => false,
                'class'=> Equipements::class,
                'expanded' => true,
                'multiple' => true,
                'choice_attr' => array('checked'=>false),
                'choice_label' => 'nom',
                'required' => false
            ])
            ->add('Rechercher', SubmitType::class);
    }

   
}
