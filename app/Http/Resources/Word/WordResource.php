<?php

namespace App\Http\Resources\Word;

use Illuminate\Http\Resources\Json\JsonResource;

class WordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'original' => $this->original,
            'translate' => $this->translate,
            'sentences' => $this->sentences,
            'associations' => $this->associations
        ];
    }
}
