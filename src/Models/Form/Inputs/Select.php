<?php

namespace Chess\FormMaker\Models\Form\Inputs;

use Chess\FormMaker\Scopes\InputScope;
use Chess\FormMaker\Traits\{
    HasInputs,
    Properties\HasAutocomplete,
    Properties\HasMultiple,
    Properties\HasReadonly,
    Properties\HasRequired,
    Properties\HasSize
};
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Select extends Input
{
    use HasAutocomplete, HasInputs, HasMultiple, HasReadonly, HasRequired,
        HasSize;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['options'];

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

    /**
     * Add options for the select input.
     *
     * @param array ...$options
     * @return Select
     * @throws \Exception
     */
    public function withOptions(array ...$options): self
    {
        foreach ($options as $optionValues)
        {
            $this->add('option')
                ->withHtmlProperties($optionValues)
                ->save();
        }

        return $this;
    }

    // ELOQUENT RELATIONSHIPS
    // ==============================================================

    /**
     * Get the options that belongs to the select input.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function options(): MorphMany
    {
        return $this->morphMany('Chess\FormMaker\Models\Form\Inputs\Option', 'inputable');
    }
}
