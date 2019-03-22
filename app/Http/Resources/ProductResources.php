<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => ucwords($this->product_name),
            'quantity' => $this->quantity,
            'price' => '$'.number_format($this->price_per_item),
            'total_value' => '$'.number_format($this->price_per_item * $this->quantity),
            'human_readable_date' => $this->created_at->diffForHumans()
        ];
    }


}
