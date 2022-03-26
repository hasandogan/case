<?php

namespace App\Service;

use App\Entity\BusinessTask;
use App\Entity\DeveloperEntity;
use App\Entity\DeveloperJobs;
use Doctrine\ORM\EntityManagerInterface;

class CalculatorService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculator()
    {
        $developer = $this->entityManager->getRepository(DeveloperEntity::class)->findBy([], ['difficulty' => 'DESC']);
        $businessTask = $this->entityManager->getRepository(BusinessTask::class)->findBy([], ['difficulty' => 'DESC']);
        $weekly = 45;
        $week = 1;

        do {
            /**
             * @var DeveloperEntity $dev
             */
            foreach ($developer as $dev) {
                /**
                 * @var BusinessTask $jobs
                 */
                foreach ($businessTask as $jobs) {
                    $jobDurationForThisDeveloper = $jobs->getDifficulty() / $dev->getDifficulty();
                    if ($jobDurationForThisDeveloper <= $jobs->getDuration()) {

                        $canDeveloperDoThisTask = $this->checkDurationOfDeveloper($dev->getId(), $weekly, $jobDurationForThisDeveloper, $week);
                        if (!$canDeveloperDoThisTask) {
                            continue;
                        }
                        if ($this->checkTaskId($jobs->getId())) {
                            continue;
                        }
                        $developerJobs = new DeveloperJobs();
                        $developerJobs->setDevId($dev->getId());
                        $developerJobs->setTaskId($jobs->getId());
                        $developerJobs->setDuration($jobDurationForThisDeveloper);
                        $developerJobs->setWeek($week);

                        $this->entityManager->persist($developerJobs);
                        $this->entityManager->flush();

                    }
                }
            }
            $week++;
        }
        while (!$this->isAllJobsDone($businessTask)) ;
    }

    public function checkDurationOfDeveloper($devId, $weekly, $jobDurationForThisDeveloper,$week)
    {
        /**
         * @var DeveloperJobs $developer
         */
        $developersJobs = $this->entityManager->getRepository(DeveloperJobs::class)->findByCountDuration($devId,$week);

        if (!$developersJobs) {
            return true;
        }
        $totalDurationOfDeveloper = $developersJobs[0];

        $result = $weekly > ($totalDurationOfDeveloper + $jobDurationForThisDeveloper);
        return $result;
    }

    public function checkTaskId($taskId)
    {
        /**
         * @var DeveloperJobs $developer
         */

        $developersJobsTask = $this->entityManager->getRepository(DeveloperJobs::class)->findOneBy(['taskId' => $taskId]);
        if ($developersJobsTask) {
            return true;
        }
    }

    public function isAllJobsDone($businessTask)
    {
        if (!$businessTask || count($businessTask) == 0) {
                return true;
        }
        $developersJobs = $this->entityManager->getRepository(DeveloperJobs::class)->findAll();
        return count($businessTask) == count($developersJobs) ;
    }

}
