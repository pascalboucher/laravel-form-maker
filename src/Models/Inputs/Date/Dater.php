<?php

namespace Belvedere\FormMaker\Models\Inputs\Date;

use Belvedere\FormMaker\{
    Contracts\Inputs\Date\DaterContract,
    Models\Inputs\Input,
    Scopes\ModelScope
};

class Dater extends Input implements DaterContract
{
    /**
     * Apply the type scope.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ModelScope('date'));
    }

    /**
     * Date constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->htmlAttributesAvailable = array_merge($this->htmlAttributesAvailable, [
            'max',
            'min',
            'step',
        ]);
    }
}
