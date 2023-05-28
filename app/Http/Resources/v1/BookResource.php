<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'id'                 => $this->id,
            'titulo'             => $this->titulo,
            'usuario_publicador' => new UserResource($this->whenLoaded('user')),
            'indices'            => BookIndexeResource::collection($this->whenLoaded('indexes')),
        ];
    }
}