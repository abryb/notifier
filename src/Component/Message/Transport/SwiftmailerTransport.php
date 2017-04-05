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

class SwiftmailerTransport implements TransportInterface
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
    public function send(MessageInterface $message): bool
    {
        $swiftMessage = \Swift_Message::newInstance()
            ->setFrom($message->getFrom())
            ->setTo($message->getTo())
            ->setSubject($message->getSubject())
            ->setBody($message->compile(), $message->getOption('contentType', 'text/html'))
            ->setCharset($message->getOption('charset', 'utf-8'));

        if ($message->hasOption('cc')) {
            $swiftMessage->setCc($message->getOption('cc'));
        }

        if ($message->hasOption('bcc')) {
            $swiftMessage->setBcc($message->getOption('bcc'));
        }

        if ($message->hasOption('replyTo')) {
            $swiftMessage->setReplyTo($message->getOption('replyTo'));
        }

        if ($message->hasOption('returnPath')) {
            $swiftMessage->setReturnPath($message->getOption('returnPath'));
        }

        if ($message->hasOption('attachments')) {
            $attachments = $message->getOption('attachments', array());

            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $this->attach($attachment, $swiftMessage);
                }
            }
        }

        $status = $this->swiftmailer->send($swiftMessage);

        return $status > 0 ? true : false;
    }

    protected function attach(array $attachment, \Swift_Message $swiftMessage)
    {
        if (!isset($attachment['type'])) {
            return;
        }

        $swiftAttachment = null;

        switch ($attachment['type']) {
            case 'file':
                $swiftAttachment = \Swift_Attachment::fromPath($attachment['path']);

                if ($attachment['filename']) {
                    $swiftAttachment->setFilename($attachment['filename']);
                }

                break;
            case 'data':
                $swiftAttachment = \Swift_Attachment::newInstance($attachment['data'], $attachment['filename'], $attachment['mimetype']);
                break;
        }

        if ($swiftAttachment) {
            $swiftMessage->attach($swiftAttachment);
        }

        return $this;
    }
}
