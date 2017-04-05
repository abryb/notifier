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
     * Set message subject.
     *
     * @param string $subject
     *
     * @return MessageInterface self
     */
    public function setSubject(string $subject): MessageInterface;

    /**
     * Get message subject.
     *
     * @return string
     */
    public function getSubject(): string;

    /**
     * Set message content.
     *
     * @param string $content
     *
     * @return MessageInterface self
     */
    public function setContent(string $content, array $contentVariables = null): MessageInterface;

    /**
     * Get message contents.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Set content variables.
     *
     * @param array $contentVariables
     *
     * @return MessageInterface self
     */
    public function setContentVariables(array $contentVariables): MessageInterface;

    /**
     * Get content variables.
     *
     * @return array
     */
    public function getContentVariables(): array;

    /**
     * Set message template.
     *
     * @param string $template template path
     *
     * @return MessageInterface self
     */
    public function setTemplate(string $template, array $templateVariables = null): MessageInterface;

    /**
     * Get message template.
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Set template variables.
     *
     * @param array $templateVariables
     *
     * @return MessageInterface self
     */
    public function setTemplateVariables(array $templateVariables): MessageInterface;

    /**
     * Get template variables.
     *
     * @return array
     */
    public function getTemplateVariables(): array;

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
     * Set message option.
     *
     * @param string $name
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    public function getOption(string $name, $defaultValue = null);

    /**
     * Has message option.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasOption(string $name): bool;

    /**
     * Get all options.
     *
     * @return array
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

    /**
     * Compile template and message
     * content into one text.
     *
     * @return string
     */
    public function compile();
}
