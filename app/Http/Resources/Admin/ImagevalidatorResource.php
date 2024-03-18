<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagevalidatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        return [
           'success'=>true,
           'application'=>"CONTROL_PANEL",
           'message' => 'Image  uploaded successfully.',
           'data' => $data,
            // Add any other attributes you want to include in the resource
        ];
    }
}
