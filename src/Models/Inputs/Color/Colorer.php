<?php

namespace Belvedere\FormMaker\Models\Inputs\Color;

use Belvedere\FormMaker\Contracts\Inputs\Color\ColorerContract;
use Belvedere\FormMaker\Models\Inputs\AbstractInputs;
use Belvedere\FormMaker\Scopes\ModelScope;

class Colorer extends AbstractInputs implements ColorerContract
{
    /**
     * Apply the type scope.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ModelScope('color'));
    }

    /**
     * Color constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->htmlAttributesAvailable = array_merge($this->htmlAttributesAvailable, [
            'autocomplete',
            'required',
        ]);
    }
}
