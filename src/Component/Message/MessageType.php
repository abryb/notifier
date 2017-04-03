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

class MessageType
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var MessageTransportInterface
     */
    protected $transport;

    /**
     * @var string
     */
    protected $class;

    /**
     * {inheritdoc}.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {inheritdoc}.
     */
    public function setName(string $typeName)
    {
        $this->name = $typeName;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {inheritdoc}.
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * {inheritdoc}.
     */
    public function createMessage()
    {
        $class = $this->getClass();

        if (!$class || !class_exists($class)) {
            throw new InvalidMessageClassException(sprintf(
                'Could not create message of given class `%s`', $class
            ));
        }

        $message = new $class();
        $message->setType($this);

        return $message;
    }

    /**
     * {inheritdoc}.
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * {inheritdoc}.
     */
    public function setTransport(MessageTransportInterface $transport)
    {
        $this->transport = $transport;

        return $this;
    }
}
