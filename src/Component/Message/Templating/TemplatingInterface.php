<?php

/*
 * This file is part of notifier component
 *
 * (c) Krystian Karaś <dev@karashome.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Staccato\Component\Notifier\Message\Templating;

interface TemplatingInterface
{
    /**
     * Render template.
     * 
     * @param string $template          template path
     * @param array  $templateVariables template viariables
     * 
     * @return string rendered template
     */
    public function render(string $template, array $templateVariables = array()): string;
}
