<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 27/05/2016
 * Time: 23:12
 */

namespace Maps_red\TicketingBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewTicket
 * @package TicketBundle\Form
 */
class CreateTicketForm extends AbstractType
{

    /** @var string $categoryClass*/
    private $categoryClass;

    /**  @var string $ticketClass */
    private $ticketClass;

    /**
     * CreateTicketForm constructor.
     * @param string $categoryClass
     * @param string $ticketClass
     */
    public function __construct(string $categoryClass, string $ticketClass)
    {
        $this->categoryClass = $categoryClass;
        $this->ticketClass = $ticketClass;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => $this->categoryClass,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.position', 'ASC');
                },
                'choice_label' => 'name',
                'label' => "label.category",
                'attr' => ['class' => 'select2'],
            ])
            ->add("text", TextareaType::class, ['label' => "label.text"])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => $this->ticketClass,
            'translation_domain' => 'ticket'
        ]);
    }

}