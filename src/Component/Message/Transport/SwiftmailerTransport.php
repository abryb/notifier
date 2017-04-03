<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Component\Notifier\Message\Transport;

use Staccato\Component\Notifier\Message\MessageInterface;
use Staccato\Component\Notifier\Message\MessageTransportInterface;

class SwiftmailerTransport implements MessageTransportInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $swiftmailer;

    public function __construct(\Swift_Mailer $swiftmailer)
    {
        $this->swiftmailer = $swiftmailer;
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message)
    {
        $message = \Swift_Message::newInstance()
            ->setFrom($message->getFrom())
            ->setTo($message->getTo())
            ->setSubject($message->getSubject())
            ->setBody($message->getContent(), 'text/html')
            ->setCharset('utf-8');

        $status = $this->swiftmailer->send($message);

        return $status;
    }
}
