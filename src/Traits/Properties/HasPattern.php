<?php

namespace Chess\FormMaker\Traits\Properties;

trait HasPattern
{
    /**
     * Specifies a regular expression that the input field value is checked against.
     *
     * @param string $pattern
     * @return self
     */
    public function propertyPattern(?string $pattern): self
    {
        $this->html_properties = ['pattern' => $pattern];

        return $this;
    }
}
