<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['id' => $this->id,
        'category_id' => $this->category_id,
        'name' => $this->name,
        'slug' => $this->slug,
        'price' => $this->price,
        'assets' => ProductAssetResource::collection($this->assets),];
    }
}
