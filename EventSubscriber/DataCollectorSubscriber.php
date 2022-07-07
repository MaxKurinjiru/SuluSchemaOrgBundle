<?php

/**
 * This file is part of Sulu SchemaOrg Bundle.
 *
 * (c) Pablo Lozano <lozanomunarriz@gmail.com>
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace Plozmun\Bundle\SuluSchemaOrgBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Plozmun\Bundle\SuluSchemaOrgBundle\Factory\SchemaOrgFactory;
use Plozmun\Bundle\SuluSchemaOrgBundle\HttpFoundation\RequestChainCollector;

class DataCollectorSubscriber implements EventSubscriberInterface
{
    private RequestChainCollector $requestChainCollector;
    private SchemaOrgFactory $factory;

    public function __construct(
        RequestChainCollector $requestChainCollector,
        SchemaOrgFactory $factory
    ) {
        $this->requestChainCollector = $requestChainCollector;
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 1],
            KernelEvents::RESPONSE => ['onKernelResponse', 1],
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        $this->requestChainCollector->analyze($request);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        $this->factory->build($request, $response);
    }
}
