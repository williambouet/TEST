<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => "form-label",
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le petit prince'
                ]
            ])
            ->add('avatarFile', VichFileType::class, [
                'label' => 'Avatar',
                'attr' => [
                    'class'=> 'form-control',
                ],
                'label_attr' => [
                    'class' => "form-label mt-2",
                ],
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email de connexion',
                'label_attr' => [
                    'class' => "form-label",
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'monEmail@gmail.com'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions : ',
                'label_attr' => [
                    'class' => "form-label",
                ],
                'attr' => [
                    'class' => "form-check-label",
                ],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez être en accord avec notre politique.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => "form-label",
                ],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => "form-control",
                    'placeholder' => 'Mon mot de passe secret'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner un mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire {{ limit }} caractères minimum.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
