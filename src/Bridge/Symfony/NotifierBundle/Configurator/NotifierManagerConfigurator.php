<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Bundle\NotifierBundle\Configurator;

use Staccato\Component\Notifier\Message\MessageType;
use Staccato\Component\Notifier\NotifierManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotifierManagerConfigurator
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $config;

    public function __construct(ContainerInterface $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Configure notifier manager.
     *
     * @param NotifierManagerInterface $notifierManager
     */
    public function configure(NotifierManagerInterface $notifierManager)
    {
        if (isset($this->config['message_types'])) {
            foreach ($this->config['message_types'] as $typeName => $type) {
                $messageType = new MessageType();
                $messageType->setName($typeName);
                $messageType->setClass($type['class']);
                $messageType->setTransport($this->container->get($type['transport']));
                $messageType->setDefaultValues($type['default_values']);

                $notifierManager->addMessageType($messageType);
            }
        }
    }
}
