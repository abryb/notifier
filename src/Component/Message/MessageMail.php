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

class MessageMail extends Message
{
    /**
     * Set Cc.
     *
     * @param mixed $cc
     *
     * @return MessageInterface
     */
    public function setCc($cc): MessageInterface
    {
        return $this->setOption('cc', $cc);
    }

    /**
     * Get Cc.
     *
     * @return mixed
     */
    public function getCc()
    {
        return $this->getOption('cc', '');
    }

    /**
     * Set Bcc.
     *
     * @param mixed $bcc
     *
     * @return MessageInterface
     */
    public function setBcc($bcc): MessageInterface
    {
        return $this->setOption('bcc', $bcc);
    }

    /**
     * Get Bcc.
     *
     * @return mixed
     */
    public function getBcc()
    {
        return $this->getOption('bcc', '');
    }

    /**
     * Set reply to.
     *
     * @param mixed $replyTo
     *
     * @return MessageInterface
     */
    public function setReplyTo($replyTo): MessageInterface
    {
        return $this->setOption('replyTo', $replyTo);
    }

    /**
     * Get replty to.
     *
     * @return mixed
     */
    public function getReplyTo()
    {
        return $this->getOption('replyTo', '');
    }

    /**
     * Set return path.
     *
     * @param string $returnPath
     *
     * @return MessageInterface
     */
    public function setReturnPath(string $returnPath): MessageInterface
    {
        return $this->setOption('returnPath', $returnPath);
    }

    /**
     * Get return path.
     *
     * @return string
     */
    public function getReturnPath(): string
    {
        return $this->getOption('returnPath', '');
    }

    /**
     * Attach file from path.
     *
     * @param string $path     file path
     * @param string $filename set attachment filename (optional)
     *
     * @return MessageInterface self
     */
    public function attachFile(string $path, string $filename = null): MessageInterface
    {
        $attachments = $this->getOption('attachments', array());
        $attachments[] = array(
            'type' => 'file',
            'path' => $path,
            'filename' => $filename,
        );

        $this->setOption('attachments', $attachments);

        return $this;
    }

    /**
     * Attach from raw data.
     *
     * @param mixed  $data     attachment content
     * @param string $filename attachment filename
     * @param string $mimeType data mime-type (optional)
     *
     * @return MessageInterface self
     */
    public function attach($data, string $filename, string $mimeType = null): MessageInterface
    {
        if ($mimeType === null || $mimeType === '') {
            $mimeType = 'application/octet-stream';
        }

        $attachments = $this->getOption('attachments', array());
        $attachments[] = array(
            'type' => 'data',
            'data' => $data,
            'filename' => $filename,
            'mimetype' => $mimeType,
        );

        $this->setOption('attachments', $attachments);

        return $this;
    }
}
