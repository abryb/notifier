<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Component\Notifier;

use Staccato\Component\Notifier\Message\Exception\InvalidMessageTypeException;
use Staccato\Component\Notifier\Message\MessageInterface;
use Staccato\Component\Notifier\Message\MessageType;

class NotifierManager implements NotifierManagerInterface
{
    /**
     * @var array
     */
    protected $messageTypes = array();

    /**
     * {@inheritdoc}
     */
    public function addMessageType(MessageType $messageType): NotifierManagerInterface
    {
        $this->messageTypes[$messageType->getName()] = $messageType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeMessageType(string $typeName): NotifierManagerInterface
    {
        if (isset($this->messageTypes[$typeName])) {
            unset($this->messageTypes[$typeName]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageType(string $typeName): MessageType
    {
        if (isset($this->messageTypes[$typeName])) {
            $messageType = $this->messageTypes[$typeName];

            if ($messageType instanceof MessageType) {
                return $messageType;
            }
        }

        throw new InvalidMessageTypeException(sprintf('Invalid message type `%s`', $typeName));
    }

    /**
     * {@inheritdoc}
     */
    public function createMessage(string $typeName): MessageInterface
    {
        $messageType = $this->getMessageType($typeName);
        $message = $messageType->createMessage();

        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message)
    {
        return $message->send();
    }
}
