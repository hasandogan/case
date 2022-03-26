<?php

namespace App\CompilerPass;

use App\Service\Resolver\ResolverInterFace;
use App\Util\Resolver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ResolverCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $context = $container->findDefinition(Resolver::class);
        $taggedServices = $container->findTaggedServiceIds(ResolverInterFace::SERVICE_TAG);
        $taggedServiceIds = array_keys($taggedServices);
        foreach ($taggedServiceIds as $taggedServiceId) {
            /** @var $taggedServiceId */
            $context->addMethodCall('addStrategy', [new Reference($taggedServiceId)]);
        }
    }

}
