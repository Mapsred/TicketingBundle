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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Description', TextareaType::class, [
                'label' => "label.description",
            ])
            ->add('Category', EntityType::class, [
                'class' => $this->categoryClass,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.position', 'ASC');
                },
                'choice_label' => 'name',
                'label' => "label.category",
                'attr' => ['class' => 'select2'],
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