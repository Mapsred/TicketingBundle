<?php

namespace Maps_red\TicketingBundle\Maker;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\Mapping\Column;
use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Entity\TicketCategory;
use Maps_red\TicketingBundle\Entity\TicketComment;
use Maps_red\TicketingBundle\Entity\TicketHistory;
use Maps_red\TicketingBundle\Entity\TicketKeyword;
use Maps_red\TicketingBundle\Entity\TicketPriority;
use Maps_red\TicketingBundle\Entity\TicketStatus;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\MakerBundle\FileManager;

class MakeTicketing extends AbstractMaker
{
    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * Return the command name for your maker (e.g. make:report).
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return "make:ticketing";
    }

    /**
     * @param Command $command
     * @param InputConfiguration $inputConfig
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription('Create the entities and repositories')
            ->setHelp("The <info>%command.name%</info> command generates the Ticket entities.")
            ->addOption('regenerate', null, InputOption::VALUE_NONE, 'Simply generate the class');
    }

    /**
     * Called after normal code generation: allows you to do anything.
     *
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Generator $generator
     * @throws \Exception
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $classes = [
            Ticket::class,
            TicketCategory::class,
            TicketComment::class,
            TicketHistory::class,
            TicketKeyword::class,
            TicketStatus::class,
            TicketPriority::class
        ];

        foreach ($classes as $classFQN) {
            $regenerate = $input->getOption('regenerate');
            $className = substr($classFQN, strrpos($classFQN, '\\') + 1);
            $entityClassDetails = $generator->createClassNameDetails($className, 'Entity\\');

            $repositoryClassDetails = $generator->createClassNameDetails(
                $entityClassDetails->getRelativeName(),
                'Repository\\',
                'Repository'
            );

            $this->remove($entityClassDetails, $io, $regenerate);
            $this->remove($repositoryClassDetails, $io, $regenerate);

            if (!class_exists($entityClassDetails->getFullName()) || $regenerate) {
                $this->generateEntity($generator, $entityClassDetails, $repositoryClassDetails, $className, $classFQN);
            }

            if (!class_exists($repositoryClassDetails->getFullName()) || $regenerate) {
                $this->generateRepository($generator, $entityClassDetails, $repositoryClassDetails, $className, $classFQN);
            }

            $generator->writeChanges();

        }
    }

    /**
     * @param ClassNameDetails $classDetails
     * @param ConsoleStyle $io
     * @param bool $regenerate
     * @throws \Exception
     */
    private function remove(ClassNameDetails $classDetails, ConsoleStyle $io, bool $regenerate)
    {
        if (class_exists($classDetails->getFullName()) && $regenerate) {
            if (null !== $targetPath = $this->fileManager->getRelativePathForFutureClass($classDetails->getFullName())) {
                unlink($targetPath);
                $io->comment(sprintf('<fg=red>%s</>: %s', "removed", $targetPath));
            }
        }

    }

    /**
     * @param Generator $generator
     * @param ClassNameDetails $entityClassDetails
     * @param ClassNameDetails $repositoryClassDetails
     * @param $className
     * @param $classFQN
     */
    private function generateEntity(Generator $generator, ClassNameDetails $entityClassDetails, ClassNameDetails $repositoryClassDetails, $className, $classFQN)
    {
        $generator->generateClass(
            $entityClassDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/doctrine/Entity.tpl.php',
            [
                'repository_full_class_name' => $repositoryClassDetails->getFullName(),
                'parent_name' => $className,
                'parent_namespace' => $classFQN,
            ]
        );

    }

    /**
     * @param Generator $generator
     * @param ClassNameDetails $entityClassDetails
     * @param ClassNameDetails $repositoryClassDetails
     * @param $className
     * @param $classFQN
     */
    private function generateRepository(Generator $generator, ClassNameDetails $entityClassDetails, ClassNameDetails $repositoryClassDetails, $className, $classFQN)
    {
        $entityAlias = strtolower($entityClassDetails->getShortName()[0]);
        $generator->generateClass(
            $repositoryClassDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/doctrine/Repository.tpl.php',
            [
                'entity_full_class_name' => $entityClassDetails->getFullName(),
                'entity_class_name' => $entityClassDetails->getShortName(),
                'entity_alias' => $entityAlias,
                'parent_name' => $className."Repository",
                'parent_namespace' => str_replace("Entity", "Repository", $classFQN)."Repository",
            ]
        );
    }

    /**
     * Configure any library dependencies that your maker requires.
     *
     * @param DependencyBuilder $dependencies
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // guarantee DoctrineBundle
        $dependencies->addClassDependency(DoctrineBundle::class, 'orm');

        // guarantee ORM
        $dependencies->addClassDependency(Column::class, 'orm');
    }
}
