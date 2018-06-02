<?php

namespace Maps_red\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketForm extends AbstractType
{
    /**  @var string $ticketClass */
    private $ticketClass;

    /**
     * CreateTicketForm constructor.
     * @param string $ticketClass
     */
    public function __construct(string $ticketClass)
    {
        $this->ticketClass = $ticketClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Text');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->ticketClass,
        ]);
    }
}