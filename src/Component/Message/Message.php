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

use Staccato\Component\Notifier\Message\Exception\InvalidMessageTransportException;
use Staccato\Component\Notifier\Message\Exception\InvalidMessageTypeException;

class Message implements MessageInterface
{
    /**
     * @var mixed
     */
    protected $from;

    /**
     * @var mixed
     */
    protected $to;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var MessageType
     */
    protected $type;

    /**
     * {inheritdoc}.
     */
    public function setFrom($from): MessageInterface
    {
        $this->from = $from;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * {inheritdoc}.
     */
    public function setTo($to): MessageInterface
    {
        $this->to = $to;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * {inheritdoc}.
     */
    public function setSubject($subject): MessageInterface
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {inheritdoc}.
     */
    public function setContent($content): MessageInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {inheritdoc}.
     */
    public function setOption(string $name, $value): MessageInterface
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function getOption(string $name, $defaultValue = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $defaultValue;
    }

    /**
     * {inheritdoc}.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {inheritdoc}.
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * {inheritdoc}.
     */
    public function setType(MessageType $type): MessageInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function send()
    {
        $messageType = $this->getType();

        if ($messageType instanceof MessageType) {
            $transport = $messageType->getTransport();

            if ($transport instanceof MessageTransportInterface) {
                return $transport->send($this);
            }

            throw new InvalidMessageTransportException(sprintf(
                'Message transport must be instance of `%s`.', MessageTransportInterface::class
            ));
        }

        throw new InvalidMessageTypeException(sprintf('Message type must be instance of `%s`.', MessageType::class));
    }
}
