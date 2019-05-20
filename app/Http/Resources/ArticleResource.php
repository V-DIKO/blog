<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
           'id'=>$this->id,
           'title'=>$this->title,
           'image'=>url(config('blog.uploads.webpath') . '/' . $this->page_image),
           'content'=>$this->content,
           'author'=>'VDiko',
           'posted_at' => $this->publish_date,
           'views'=>rand(10000,99999),
           'rote'=>rand(100,999)
       ];
    }
}
