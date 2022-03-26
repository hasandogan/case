<?php

namespace App\Service\Resolver;

interface ResolverInterFace
{
    public const SERVICE_TAG = 'resolver_strategy';

    public function isResolvable($type);

    public function resolver(iterable $payload = []): void;

}
