<?php

namespace App\Form;


use Symfony\Component\Form\FormBuilderInterface;



class UserType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('email')
            ->remove('plainPassword')
            ->remove('agreeTerms');
    }

}
