<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentsCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
         return $this->collection->map(static function ($department) {
             return [
                 'name' => $department->name,
                 'description' => $department->description,
                 'logo_id' => $department->logo_id
             ];
         });
    }
}
