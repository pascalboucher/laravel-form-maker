<?php

namespace Belvedere\FormMaker\Http\Resources\Nodes\Inputs;

use Illuminate\Http\Resources\Json\JsonResource;
use Belvedere\FormMaker\Http\Resources\Nodes\NodeCollection;
use Belvedere\FormMaker\Contracts\Http\Resources\Nodes\Inputs\InputResourcerContract;
use Belvedere\FormMaker\Contracts\Http\Resources\Nodes\Siblings\LabelResourcerContract;

class InputResourcer extends JsonResource implements InputResourcerContract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if ($options = method_exists($this->resource, 'options')) {
            $options = new NodeCollection($this->options());
        }

        $label = $this->getLabelResource();

        return [
            'id' => $this->getKey(),
            'type' => $this->type,
            $this->mergeWhen($this->text, [
                'text' => $this->text,
            ]),
            $this->mergeWhen($this->html_attributes, [
                'html_attributes' => $this->html_attributes,
            ]),
            $this->mergeWhen(! is_null($label), [
                'label' => $label,
            ]),
            $this->mergeWhen($options && $options->count() > 0, [
                'options' => $options,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get the label api resource.
     *
     * @return \Belvedere\FormMaker\Contracts\Http\Resources\Nodes\Siblings\LabelResourcerContract|null
     */
    protected function getLabelResource(): ?LabelResourcerContract
    {
        if ($this->label) {
            $this->label->setParentRelation($this->resource);

            return $this->label->toApi();
        }

        return $this->label;
    }
}
