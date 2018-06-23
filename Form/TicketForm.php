<?php

namespace Maps_red\TicketingBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketForm extends AbstractType
{

    /** @var string $categoryClass */
    private $categoryClass;

    /**  @var string $ticketClass */
    private $ticketClass;

    /** @var string $priorityClass */
    private $priorityClass;

    /**
     * TicketForm constructor.
     * @param string $categoryClass
     * @param string $ticketClass
     * @param string $priorityClass
     */
    public function __construct(string $categoryClass, string $ticketClass, string $priorityClass)
    {
        $this->categoryClass = $categoryClass;
        $this->ticketClass = $ticketClass;
        $this->priorityClass = $priorityClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => "label.description",
            ])
            ->add('category', EntityType::class, [
                'class' => $this->categoryClass,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.position', 'ASC');
                },
                'choice_label' => 'name',
                'label' => "label.category",
                'attr' => ['data-provider' => 'select2'],
            ])->add('priority', EntityType::class, [
                'class' => $this->priorityClass,
                'choice_label' => 'value',
                'label' => "label.priority",
                'attr' => ['data-provider' => 'select2'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->ticketClass,
            'translation_domain' => 'TicketingBundle'
        ]);
    }
}