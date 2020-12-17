<?php declare(strict_types=1);

namespace GW\SymfonyJsonRequest;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SymfonyJsonRequestBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $definition = new Definition(JsonBodyToRequestListener::class);

        $definition->addTag('kernel.event_listener', [
            'event' => 'kernel.request',
        ]);

        $container->setDefinition(JsonBodyToRequestListener::class, $definition);
    }
}
