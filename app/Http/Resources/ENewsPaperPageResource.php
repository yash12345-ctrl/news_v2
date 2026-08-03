<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ENewsPaperPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "photo_url" => $this->page_url,
            "page_url" => $this->page_url,
            "page_number" => $this->page_number,
            "enews_paper_id" => $this->enews_paper_id,
        ];
    }
}
