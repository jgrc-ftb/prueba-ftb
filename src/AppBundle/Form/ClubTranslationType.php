<?php
namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClubTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'club',
                HiddenType::class,
                [
                    'data' => $options['data']['default_club']
                ]
            )
            ->add(
                'language',
                ChoiceType::class,
                [
                    'choices' => $this->getLanguageChoices(
                        $options['data']['default_languages']
                    )
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'constraints' => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Create'
                ]
            );
    }

    private function getLanguageChoices(array $languages): array
    {
        $choices = [];
        foreach($languages as $language) {
            $choices[$language->getName()] = $language->getId();
        }

        return $choices;
    }
}