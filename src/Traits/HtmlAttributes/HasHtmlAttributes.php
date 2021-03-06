<?php

namespace Belvedere\FormMaker\Traits\HtmlAttributes;

use Belvedere\FormMaker\Contracts\Models\HtmlAttributes\HtmlAttributerContract;
use Belvedere\FormMaker\Contracts\Traits\HtmlAttributes\HasHtmlAttributesContract;

trait HasHtmlAttributes
{
    /**
     * The current implementation of the HtmlAttributerContract.
     *
     * @var mixed
     */
    protected $htmlAttributesProvider;

    /**
     * Check if the attribute is available for the model.
     *
     * @param string $attribute
     * @return bool
     */
    protected function attributeIsAvailable(string $attribute): bool
    {
        return in_array($attribute, $this->htmlAttributesAvailable);
    }

    /**
     * Mass removal of html attributes to a model.
     *
     * @param array $attributes
     * @return \Belvedere\FormMaker\Contracts\Traits\HtmlAttributes\HasHtmlAttributesContract
     */
    public function removeHtmlAttributes(array $attributes): HasHtmlAttributesContract
    {
        $this->updateHtmlAttributes(array_fill_keys($attributes, null));

        return $this;
    }

    /**
     * Update the existing list of attributes.
     *
     * @param array $attributes
     * @return void
     */
    protected function updateHtmlAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute => $value) {
            if (is_null($value) || $this->attributeIsAvailable($attribute)) {
                $this->htmlAttributesProvider->$attribute = $value;
            }
        }

        $this->html_attributes = $this->htmlAttributesProvider->getHtmlAttributes();

        $this->htmlAttributesProvider->clearHtmlAttributes();
    }

    /**
     * Set the model html attributes.
     *
     * @param  array $attributes
     * @return void
     */
    public function setHtmlAttributesAttribute(array $attributes): void
    {
        if (isset($this->attributes['html_attributes'])) {
            $attributes = array_filter(array_merge($this->html_attributes, $attributes), function ($attribute) {
                return ! is_null($attribute);
            });
        }
        $this->attributes['html_attributes'] = json_encode($attributes);
    }

    /**
     * Set the html attributes provider used by the model.
     *
     * @return void
     */
    public function setHtmlAttributesProvider(): void
    {
        $this->htmlAttributesProvider = resolve(HtmlAttributerContract::class);
    }

    /**
     * Mass assign html attributes to a model.
     *
     * @param array $attributes
     * @return \Belvedere\FormMaker\Contracts\Traits\HtmlAttributes\HasHtmlAttributesContract
     */
    public function withHtmlAttributes(array $attributes): HasHtmlAttributesContract
    {
        $this->updateHtmlAttributes($attributes);

        return $this;
    }
}
