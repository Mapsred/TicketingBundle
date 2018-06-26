<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 28/05/2016
 * Time: 21:49
 */

namespace Maps_red\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketCommentForm extends AbstractType
{
    /** @var string $commentClass */
    private $commentClass;

    /**
     * TicketForm constructor.
     * @param string $commentClass
     */
    public function __construct(string $commentClass)
    {
        $this->commentClass = $commentClass;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("text", TextareaType::class, ['label' => "label.comment", 'required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => $this->commentClass,
            'translation_domain' => 'TicketingBundle'
        ]);
    }

}