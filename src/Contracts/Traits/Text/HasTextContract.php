<?php

namespace Belvedere\FormMaker\Contracts\Traits\Text;

interface HasTextContract
{
    /**
     * Add a text value to the model.
     *
     * @param string $text
     * @return mixed
     */
    public function withText(string $text);
}
