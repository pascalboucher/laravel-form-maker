<?php

namespace Belvedere\FormMaker\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if ($inputs = method_exists($this->resource, 'inputs')) {
            $inputs = new InputCollection($this->inputs());
        } else if ($inputs = method_exists($this->resource, 'options')) {
            $inputs = new InputCollection($this->options()->get());
        }

        return [
            'id' => $this->id,
            $this->mergeWhen($inputs && $inputs->collection->isNotEmpty(), [
                'children' => $inputs,
            ]),
            $this->mergeWhen($this->html_attributes, [
                'attributes' => $this->html_attributes,
            ]),
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
