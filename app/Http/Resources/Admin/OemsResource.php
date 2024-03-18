<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->resource === null) {
            return [
                'success'=>false,
                'application'=>"CONTROL_PANEL",
                'message' => 'OEMS operation failed.',
                'data' => "",
            ];
        }

        if ($this->resource === "Saved") {
            return [
                'success'=>true,
                'application'=>"CONTROL_PANEL",
                'message' => 'OEMS Saved.',
                'data' => "",
            ];
        }

        if ($this->resource === "Deleted") {
            return [
                'success'=>true,
                'application'=>"CONTROL_PANEL",
                'message' => 'OEMS Deleted.',
                'data' => "",
            ];
        }

        $data =  parent::toArray($request);
        return [
            'success'=>true,
            'application'=>"CONTROL_PANEL",
            'data' => $data,
            // Add any other attributes you want to include in the resource
        ];
    }
}
