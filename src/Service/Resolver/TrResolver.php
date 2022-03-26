<?php

namespace App\Service\Resolver;


use App\Entity\BusinessTask;

class TrResolver implements ResolverInterFace
{
    private $key = 'TrResolver';

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
            $businessTask->setDuration($data['sure']);
            $businessTask->setDifficulty($data['zorluk']);

            $payload['entityManager']->persist($businessTask);
        }
        $payload['entityManager']->flush();

    }


}
