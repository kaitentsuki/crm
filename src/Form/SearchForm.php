<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("search_by", ChoiceType::class, [
                'choices' => [
                    'Firstname' => '0',
                    'Lastname' => "1",
                    'Card number' => "2"
                ]
            ])
            ->add("search_input", TextType::class)
        ;
    }
}