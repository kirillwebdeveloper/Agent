<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form for logging in a user.
 */
class LoginType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                '_username',
                TextType::class
            )
            ->add(
                '_password',
                PasswordType::class
            )
            ->add(
                '_remember_me',
                CheckboxType::class,
                [
                    'data' => true,
                    'required' => false
                ]
            )
        ;

        $builder->setAction($options['action']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'action' => null,
            'data_class' => null,
            'intention' => 'authenticate'
        ]);
    }

    /**
     * @return bool|string
     */
    public function getBlockPrefix()
    {
        return false;
    }
}
