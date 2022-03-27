<?php

namespace App\Service;

use App\Entity\Developer;
use Doctrine\ORM\EntityManagerInterface;

class DeveloperService
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    public function createDeveloper($data)
    {
        $developer = new Developer();

        $developer->setName($data["name"]);
        $developer->setDifficulty($data["difficulty"]);
        $developer->setDuration($data["duration"]);

        $this->entityManager->persist($developer);
        $this->entityManager->flush();
    }

}
