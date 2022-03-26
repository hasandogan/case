<?php

namespace App\Service\Resolver;


use App\Entity\BusinessTask;

class EnResolver implements ResolverInterFace
{


    private $key = 'EnResolver';

    public function isResolvable($type): bool
    {
        return $type === $this->key;
    }

    public function resolver(iterable $payload = []): void
    {

        $response = $payload['client']->request(
            'GET',
            $payload['url']
        );

        foreach (json_decode($response->getContent(), true) as $data) {
            $businessTask = new BusinessTask();
            $businessTask->setDuration(array_values($data)[0]['estimated_duration']);
            $businessTask->setDifficulty(array_values($data)[0]['level']);

            $payload['entityManager']->persist($businessTask);
        }
        $payload['entityManager']->flush();

    }


}
