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

use Staccato\Component\Notifier\Message\MessageInterface;
use Staccato\Component\Notifier\Message\MessageType;

interface NotifierManagerInterface
{
    /**
     * Add message type.
     *
     * @param MessageType $messageType
     *
     * @return NotifierManagerInterface self
     */
    public function addMessageType(MessageType $messageType): NotifierManagerInterface;

    /**
     * Remove message type.
     *
     * @param string $typeName name of message type
     *
     * @return NotifierManagerInterface self
     */
    public function removeMessageType(string $typeName): NotifierManagerInterface;

    /**
     * Get message type.
     *
     * @param string $typeName name of message type
     *
     * @throws InvalidMessageTypeException if type is not exists
     *
     * @return MessageType
     */
    public function getMessageType(string $typeName): MessageType;

    /**
     * Creates new message of given type.
     *
     * @param string $type message type
     *
     * @return MessageInterface
     */
    public function createMessage(string $typeName): MessageInterface;

    /**
     * Send message.
     *
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message);
}
