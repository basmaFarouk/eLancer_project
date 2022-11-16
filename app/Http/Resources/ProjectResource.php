<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'id'=>$this->id,
            // 'category'=>[
            //     'id'=>$this->category->id,
            //     'name'=>$this->category->name,
            // ],
            'category'=>new CategoryResource($this->category), //this->category is the relation
            'title'=>$this->title,
            'description'=>$this->description,
            'update_time'=>$this->updated_at,
            'status'=>$this->status,
            'tags'=>TagsResource::collection($this->tags),
            '_links'=>[
                '_self'=>url('api/projects/'.$this->id),
            ],
        ];
    }
}
