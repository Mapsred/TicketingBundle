<?php

namespace App\DataFixtures;

use App\Entity\TicketPriority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TicketPriorityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $statusFixture = [
            "low" => [
                "name" => "low",
                "value" => "Basse",
            ],
            "medium" => [
                "name" => "medium",
                "value" => "Moyenne",
            ],
            "high" => [
                "name" => "high",
                "value" => "Haute",
            ],
            "critical" => [
                "name" => "critical",
                "value" => "Critique",
            ],
        ];

        foreach ($statusFixture as $name => $value) {
            $status = new TicketPriority();
            $status->setName($name)->setValue($value['value']);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
