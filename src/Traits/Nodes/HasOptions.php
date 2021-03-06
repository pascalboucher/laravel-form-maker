<?php

namespace Belvedere\FormMaker\Traits\Nodes;

use Illuminate\Support\Collection;
use Belvedere\FormMaker\Contracts\Models\Nodes\Inputs\Option\OptionerContract;

trait HasOptions
{
    /**
     * Add an option input to the parent model.
     *
     * @return \Belvedere\FormMaker\Contracts\Models\Nodes\Inputs\Option\OptionerContract
     */
    public function addOption(): OptionerContract
    {
        $option = $this->nodeRepositoryProvider->getInstanceOf($this, 'option');

        return $option;
    }

    /**
     * Add options to the parent model.
     *
     * @param array ...$options
     * @return array
     */
    public function addOptions(array ...$options): array
    {
        return array_map(function ($attributes) {
            $option = $this->addOption();

            if (count($attributes) > 0) {
                $option->withHtmlAttributes($attributes);
                if (array_key_exists('text', $attributes)) {
                    $option->withText($attributes['text']);
                }
            }

            return $option->saveAndFirst();
        }, $options);
    }

    /**
     * Get the option with the specified key.
     *
     * @param mixed $key
     * @return \Belvedere\FormMaker\Contracts\Models\Nodes\Inputs\Option\OptionerContract|null
     */
    public function option($key): ?OptionerContract
    {
        $option = $this->nodeRepositoryProvider->find($this, $key, ['id', 'value']);

        return (! is_null($option) && $option->type === 'option') ? $option : null;
    }

    /**
     * Get the options sorted by their position in the ranking.
     *
     * @return \Illuminate\Support\Collection
     */
    public function options(): Collection
    {
        $options = $this->morphMany(resolve(OptionerContract::class), 'nodable')->get();

        if ($options->isEmpty()) {
            return $options;
        }

        return $this->ranking->sortByRank($options);
    }
}
