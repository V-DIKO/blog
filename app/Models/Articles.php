<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Articles extends Model
{
    protected $dates = ['publish_at'];

    protected $fillable = [
        'title', 'subtitle', 'content_raw', 'page_image', 'meta_description','layout', 'is_draft', 'publish_at',
    ];

    public function setTitleAttribute($value){
        $this->attributes['title']=$value;

        if(!$this->exists){
            $value = uniqid(str_random(0,8));
            $this->setUniqueSlug($value, 0);
        }
    }

    public function tags(){
      return  $this->belongsToMany(Tag::class,'article_tag_pivot','article_id','tag_id');
    }

    public function setUniqueSlug($title,$extra){
        $slug = str_slug($title.'-'.$extra);
        if(static::where('slug',$slug)->exists()){
            $this->setUniqueSlug($title,$extra + 1);
        }
        $this->attributes['slug'] = $slug;
    }

    public function setContentRawAttribute($value){
        $markdowner = new Markdowner();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdowner->toHTML($value);
    }

    public function syncTags(array $tags){
        Tag::addNeededTags($tags);
        if(count($tags)){
            $this->tags()->sync(
                Tag::whereIn('tag',$tags)->get()->pluck('id')->all()
            );
            return ;
        }
        $this->tags()->detach();
    }

    public function getPublishDateAttrbute($value){
        return $this->publish_at = format('Y-m-d');
    }

    public function getPublishTimeAttrbute($value){
        return $this->publish_at = format('g:i A');
    }

    public function getContentAttrbute($value){
        return $this->content_raw;
    }

}
