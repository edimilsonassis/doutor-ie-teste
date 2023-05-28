<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookIndexeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id'         => $this->id,
            'titulo'     => $this->titulo,
            'pagina'     => $this->pagina,
            'subindices' => BookIndexeResource::collection($this->whenLoaded('indexes')),
        ];
    }
}