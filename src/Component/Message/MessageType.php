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
    protected $class = Message::class;

    /**
     * Get name of type.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name of type.
     *
     * @param string $typeName
     *
     * @return MessageType self
     */
    public function setName(string $typeName): MessageType
    {
        $this->name = $typeName;

        return $this;
    }

    /**
     * Get message class.
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Set message class.
     *
     * @param string $class
     *
     * @return MessageType self
     */
    public function setClass(string $class): MessageType
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get default message class values.
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return $this->defaultValues;
    }

    /**
     * Set default message class values.
     *
     * @param array $defaultValues
     *
     * @return MessageType self
     */
    public function setDefaultValues(array $defaultValues): MessageType
    {
        $this->defaultValues = $defaultValues;

        return $this;
    }

    /**
     * Creates instance of message
     * class and applys default values.
     *
     * @return MessageInterface
     */
    public function createMessage(): MessageInterface
    {
        $class = $this->getClass();

        if (!$class || !class_exists($class)) {
            throw new InvalidMessageClassException(sprintf(
                'Could not create message of given class `%s`', $class
            ));
        }

        $message = new $class();
        $message->setType($this);

        // apply default values
        foreach ($this->getDefaultValues() as $name => $v) {
            $fname = 'set'.ucfirst($name);

            if (method_exists($message, $fname)) {
                $message->$fname($v);
            }
        }

        return $message;
    }

    /**
     * Get message transport.
     *
     * return MessageTransportInterface|null
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Set message transport.
     *
     * return MessageType self
     */
    public function setTransport(MessageTransportInterface $transport): MessageType
    {
        $this->transport = $transport;

        return $this;
    }
}
