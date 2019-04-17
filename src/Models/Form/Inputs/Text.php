<?php

namespace Belvedere\FormMaker\Models\Form\Inputs;

use Belvedere\FormMaker\Scopes\InputScope;
use Belvedere\FormMaker\Traits\Properties\{
    HasAutocomplete,
    HasAutofocus,
    HasMinMaxLength,
    HasPattern,
    HasPlaceholder,
    HasReadonly,
    HasRequired,
    HasSize,
    HasSpellcheck
};

class Text extends Input
{
    use HasAutocomplete, HasAutofocus, HasMinMaxLength, HasPattern,
        HasPlaceholder, HasReadonly, HasRequired, HasSize, HasSpellcheck;

    /**
     * Apply the type scope.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new InputScope('text'));
    }
}
