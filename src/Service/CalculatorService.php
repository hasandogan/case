<?php

namespace App\Service;

use App\Entity\BusinessTask;
use App\Entity\Developer;
use App\Entity\DeveloperTask;
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
        $developer = $this->entityManager->getRepository(Developer::class)->findBy([], ['difficulty' => 'DESC']);
        $businessTask = $this->entityManager->getRepository(BusinessTask::class)->findBy([], ['difficulty' => 'DESC']);
        $weekly = 45;
        $week = 1;

        do {
            /**
             * @var Developer $dev
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
                        $developerTask = new DeveloperTask();
                        $developerTask->setDevId($dev->getId());
                        $developerTask->setTaskId($jobs->getId());
                        $developerTask->setDuration($jobDurationForThisDeveloper);
                        $developerTask->setWeek($week);

                        $this->entityManager->persist($developerTask);
                        $this->entityManager->flush();

                    }
                }
            }
            $week++;
        } while (!$this->isAllJobsDone($businessTask));
    }

    public function checkDurationOfDeveloper($devId, $weekly, $jobDurationForThisDeveloper, $week)
    {
        /**
         * @var DeveloperTask $developer
         */
        $developersJobs = $this->entityManager->getRepository(DeveloperTask::class)->findByCountDuration($devId, $week);

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
         * @var DeveloperTask $developer
         */

        $developersJobsTask = $this->entityManager->getRepository(DeveloperTask::class)->findOneBy(['taskId' => $taskId]);
        if ($developersJobsTask) {
            return true;
        }
    }

    public function isAllJobsDone($businessTask)
    {
        if (!$businessTask || count($businessTask) == 0) {
            return true;
        }
        $developersJobs = $this->entityManager->getRepository(DeveloperTask::class)->findAll();
        return count($businessTask) == count($developersJobs);
    }


}
