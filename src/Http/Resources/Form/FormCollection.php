<?php

namespace Belvedere\FormMaker\Http\Resources\Form;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FormCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->collection->transform(function ($form) {
            return $form->toApi();
        })->toArray();
    }
}
