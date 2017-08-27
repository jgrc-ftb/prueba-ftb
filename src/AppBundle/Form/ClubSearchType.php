<?php
namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Blank;

class ClubSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'manager',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add('search',
                SubmitType::class,
                [
                    'label' => 'Search'
                ]
            );
    }
}