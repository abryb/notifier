<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Component\Notifier\Message;

interface MessageTransportInterface
{
    /**
     * Send message.
     *
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message);
}
