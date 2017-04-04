<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Bundle\NotifierBundle\Templating;

use Staccato\Component\Notifier\Message\Templating\TemplatingInterface;

class Templating implements TemplatingInterface
{
    protected $templating;

    public function __construct($templating)
    {
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $template, array $templateVariables = array()): string
    {
        return $this->templating->render($template, $templateVariables);
    }
}
