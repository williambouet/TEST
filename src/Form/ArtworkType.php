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

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('tool')
            ->add('height')
            ->add('width')
            ->add('base')
            ->add('work_duration')
            ->add('artworkFile', VichFileType::class, [
                'label' => 'Œuvre',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => "form-label mt-2",
                ],
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'download_label' => true,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-select my-2 '],
                'by_reference' => true,
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
