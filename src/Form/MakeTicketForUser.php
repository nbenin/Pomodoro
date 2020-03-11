<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MakeTicketForUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content',  TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter some text',
                    ]),
                    new Length([
                        'min' => 25,
                        'minMessage' => 'Your text should be at least {{ limit }} characters',
                        'max' => 250,
                    ]),
                    ]
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver) // wat doet dit ????
    {
        $resolver->setDefaults([ // welke defaults worden er hier geset???
            'data_class' => Ticket::class,
        ]);
    }
}



