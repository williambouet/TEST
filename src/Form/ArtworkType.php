<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de l\'œuvre',
                'attr' => [
                    'class' => 'form-control my-2',
                ],
            ])
            ->add('tool', TextType::class, [
                'label' => 'Outil principal',
                'attr' => [
                    'class' => 'form-control my-2',
                ],
                ])
                ->add('base', TextType::class, [
                    'label' => 'Support',
                    'attr' => [
                        'class' => 'form-control my-2',
                    ],
                    ])
            ->add('height', NumberType::class, [
                'label' => 'Hauteur en cm',
                'attr' => [
                    'class' => 'form-control my-2',
                ],
            ])
            ->add('width', NumberType::class, [
                'label' => 'Largeur en cm',
                'attr' => [
                    'class' => 'form-control my-2',
                ],
            ])
            ->add('work_duration', NumberType::class, [
                'label' => 'Temps de travail en min',
                'attr' => [
                    'class' => 'form-control my-2',
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégories',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-select my-2 '],
                'by_reference' => true,
            ])
            ->add('artworkFile', VichFileType::class, [
                'label' => 'Charger une œuvre',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => "form-label my-2",
                ],
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
                'download_label' => false,
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
