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

interface MessageInterface
{
    /**
     * Set message sender.
     *
     * @return MessageInterface self
     */
    public function setFrom($from): MessageInterface;

    /**
     * Get message sender.
     *
     * @return mixed
     */
    public function getFrom();

    /**
     * Set message recipient(s).
     *
     * @param mixed $to recipient
     *
     * @return MessageInterface self
     */
    public function setTo($to): MessageInterface;

    /**
     * Get message recipient(s).
     *
     * @return mixed
     */
    public function getTo();

    /**
     * Set message content.
     *
     * @param string $content
     *
     * @return MessageInterface self
     */
    public function setContent($content): MessageInterface;

    /**
     * Get message contents.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set message option.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return MessageInterface self
     */
    public function setOption(string $name, $value): MessageInterface;

    /**
     * {inheritdoc}.
     */
    public function getOption(string $name, $defaultValue = null);

    /**
     * {inheritdoc}.
     */
    public function getOptions(): array;

    /**
     * Get message type.
     *
     * @return MessageType
     */
    public function getType(): MessageType;

    /**
     * Get message type.
     *
     * @return self
     */
    public function setType(MessageType $type);

    /**
     * Send this message.
     */
    public function send();
}
