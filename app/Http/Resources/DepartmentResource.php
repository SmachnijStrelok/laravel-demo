<?php

namespace App\Http\Resources;

use App\Http\Components\Department\Entities\Department;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Department $department */
        $department = $this->resource;
        return [
            'id' => $department->id,
            'name' => $department->name,
            'description' => $department->description,
            'logo_id' => $department->logo_id
        ];
    }
}
