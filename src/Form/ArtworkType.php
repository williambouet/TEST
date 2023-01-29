<?php

namespace App\Form;

use App\Entity\Artwork;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
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
                    'class'=> 'form-control',
                ],
                'label_attr' => [
                    'class' => "form-label mt-2",
                ],
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'download_label' => true,
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
