<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Titre de la catégorie',
            'attr' => [
                'class' => 'form-control my-2',
            ],
        ])
        ->add('categoryFile', VichFileType::class, [
            'label' => 'Charger une image',
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
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
