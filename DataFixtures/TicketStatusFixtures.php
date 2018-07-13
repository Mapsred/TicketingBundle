<?php

namespace App\DataFixtures;

use App\Entity\TicketStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TicketStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $statusFixture = [
            "open" => [
                "value" => "Ouvert",
                "style" => "success",
            ],
            "pending" => [
                "value" => "En cours",
                "style" => "warning",
            ],
            "closed" => [
                "value" => "Clos",
                "style" => "danger",
            ],
            "waiting" => [
                "value" => "En attente",
                "style" => "info",
            ],
        ];

        foreach ($statusFixture as $name => $value) {
            $status = new TicketStatus();
            $status->setName($name)->setValue($value['value'])->setStyle($value['style']);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
