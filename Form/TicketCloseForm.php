<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 29/05/2016
 * Time: 18:33
 */

namespace Maps_red\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketCloseForm extends AbstractType
{
    /** @var string $ticketClass */
    private $ticketClass;

    /**
     * TicketForm constructor.
     * @param string $ticketClass
     */
    public function __construct(string $ticketClass)
    {
        $this->ticketClass = $ticketClass;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("closureResponse", TextareaType::class, [
            'label' => "label.closure_response",
            "required" => false
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => $this->ticketClass,
            'translation_domain' => 'TicketingBundle'
        ]);
    }

}