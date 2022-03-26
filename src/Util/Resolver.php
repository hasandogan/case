<?php

namespace App\Util;



use App\Service\Resolver\ResolverInterFace;

class Resolver
{
    private $strategies;

    public function addStrategy(ResolverInterFace $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function send(string $type, iterable $payload = []): void
    {
        /** @var ResolverInterFace $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isResolvable($type)) {
                $strategy->resolver($payload);

                return;
            }
        }
    }
}
