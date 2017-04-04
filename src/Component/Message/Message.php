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

use Staccato\Component\Notifier\Message\Exception\InvalidMessageTemplatingException;
use Staccato\Component\Notifier\Message\Exception\InvalidMessageTransportException;
use Staccato\Component\Notifier\Message\Exception\InvalidMessageTypeException;
use Staccato\Component\Notifier\Message\Templating\TemplatingInterface;

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
    protected $subject = '';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var string
     */
    protected $template = '';

    /**
     * @var array
     */
    protected $contentVariables = array();

    /**
     * @var array
     */
    protected $templateVariables = array();

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var MessageType
     */
    protected $type;

    /**
     * {@inheritdoc}
     */
    public function setFrom($from): MessageInterface
    {
        $this->from = $from;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * {@inheritdoc}
     */
    public function setTo($to): MessageInterface
    {
        $this->to = $to;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(string $subject): MessageInterface
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(string $content, array $contentVariables = null): MessageInterface
    {
        $this->content = $content;

        if (is_array($contentVariables)) {
            $this->setContentVariables($contentVariables);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setContentVariables(array $contentVariables): MessageInterface
    {
        $this->contentVariables = $contentVariables;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentVariables(): array
    {
        return $this->contentVariables;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplate(string $template, array $templateVariables = null): MessageInterface
    {
        $this->template = $template;

        if (is_array($templateVariables)) {
            $this->setTemplateVariables($templateVariables);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateVariables(array $templateVariables): MessageInterface
    {
        $this->templateVariables = $templateVariables;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateVariables(): array
    {
        return $this->contentVariables;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption(string $name, $value): MessageInterface
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption(string $name, $defaultValue = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $defaultValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(MessageType $type): MessageInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
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

        throw new InvalidMessageTypeException(sprintf(
            'Message type must be instance of `%s`.', MessageType::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        $messageType = $this->getType();

        if (!$messageType instanceof MessageType) {
            throw new InvalidMessageTypeException(sprintf(
                'Message type must be instance of `%s`.', MessageType::class
            ));
        }

        return $this->compileTemplate($messageType, $this->compileContent());
    }

    /**
     * Compile content part.
     *
     * @return string
     */
    protected function compileContent(): string
    {
        $content = $this->getContent();
        $contentVariables = $this->getContentVariables();

        if (!empty($contentVariables)) {
            foreach ($contentVariables as $var => $value) {
                $content = str_replace('${'.$var.'}', $value, $content);
            }
        }

        return $content;
    }

    /**
     * Compile template part.
     *
     * @param string $content
     *
     * @throws InvalidMessageTemplatingException if provided invalid tempating
     *
     * @return string
     */
    protected function compileTemplate(MessageType $messageType, string $content): string
    {
        if ($this->getTemplate() !== '') {
            $templating = $messageType->getTemplating();

            if (!$templating instanceof TemplatingInterface) {
                throw new InvalidMessageTemplatingException(sprintf(
                    'Templating type must be instance of `%s`.', TemplatingInterface::class
                ));
            }

            $templateVariables = $this->getTemplateVariables();
            $templateVariables['content'] = $content;

            $content = $templating->render($this->getTemplate(), $templateVariables);
        }

        return $content;
    }
}
