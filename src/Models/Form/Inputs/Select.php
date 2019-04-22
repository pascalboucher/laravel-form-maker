<?php

namespace Belvedere\FormMaker\Models\Form\Inputs;

use Belvedere\FormMaker\Scopes\InputScope;
use Belvedere\FormMaker\Traits\{
    HasOptions,
    Attributes\HasAutocomplete,
    Attributes\HasMultiple,
    Attributes\HasReadonly,
    Attributes\HasRequired,
    Attributes\HasSize
};

class Select extends Input
{
    use HasAutocomplete, HasMultiple, HasOptions, HasReadonly,
        HasRequired, HasSize;

    /**
     * Apply the type scope.
     *
     * @return void
     */
    protected static function boot()
    {
        static::addGlobalScope(new InputScope('select'));

        parent::boot();
    }
}
