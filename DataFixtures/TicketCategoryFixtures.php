<?php

namespace App\DataFixtures;

use App\Entity\TicketCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TicketCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoryFixture = [
            "question" => [
                "name" => "question",
                "value" => "Question",
                "position" => "1",
            ],
            "problem" => [
                "name" => "problem",
                "value" => "Problème",
                "position" => "2",
            ],
            "bug" => [
                "name" => "bug",
                "value" => "Bug",
                "position" => "3",
            ],
            "suggestion" => [
                "name" => "suggestion",
                "value" => "Suggestion",
                "position" => "4",
            ],
        ];

        foreach ($categoryFixture as $name => $value) {
            $status = new TicketCategory();
            $status->setName($name)->setValue($value['value'])->setPosition($value['position']);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
