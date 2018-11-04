<?php

namespace Chess\FormMaker\Traits\Properties;

trait HasReadonly
{
    /**
     * Specifies that the input field is read only (cannot be changed).
     *
     * @param string $readonly
     * @return self
     */
    public function propertyReadonly(?string $readonly = 'readonly'): self
    {
        $this->html_properties = ['readonly' => $readonly];

        return $this;
    }
}
