<?php
namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                '_username',
                TextType::class
            )
            ->add(
                '_password',
                TextType::class
            )
            ->add(
                'login',
                SubmitType::class,
                ['label' => 'Login']
            );
    }

    public function getBlockPrefix()
    {
        return null;
    }
}