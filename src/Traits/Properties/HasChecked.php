<?php

namespace Chess\FormMaker\Traits\Properties;

trait HasChecked
{
    /**
     * Pre-checks the control before the user interacts with it.
     *
     * @param string $checked
     * @return self
     */
    public function htmlChecked(?string $checked = 'checked'): self
    {
        $this->html_attributes = ['checked' => $checked];

        return $this;
    }
}
