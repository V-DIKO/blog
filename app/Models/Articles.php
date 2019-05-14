<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
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

    /**
     * Return URL to post
     *
     * @param Tag $tag
     * @return string
     */
    public function url(Tag $tag=null){
        $url = url('blog/'.$this->slug);
        if($tag){
            $url .='?tag='.urlencode($tag->tag);
        }
        return $url;
    }

    /**
     * Return array of tag links
     *
     * @param string $base
     * @return array
     */
    public function tagLinks($base = '/blog?tag=%Tag%'){
        $tags = $this->tags()->get()->pluck('tag')->all();
        $return = [];
        foreach ($tags as $tag){
            $url = str_replace('%Tag%',urlencode($tag),$base);
            $return[] = '<a href="'.$url.'">e'.$tag.'</a>';
        }
        return $return;
    }

    /**
     * Return next post after this one or null
     *
     * @param Tag $tag
     * @return Post
     */

    public function newerArticle(Tag $tag=null){
        $query =static::where('publish_at','>',$this->publish_at)
            ->where('publish_at','<',Carbon::now())
            ->where('is_draft',0)
            ->orderBy('publish_at','asc');
        if($tag){
            $query = $query->whereHas('tags',function($q)use($tag){
               $q->where('tag','=',$this->tag);
            });
        }
        return $query->first();
    }

    /**
     * Return older post before this one or null
     *
     * @param Tag $tag
     * @return Post
     */
    public function olderArticle(Tag $tag=null){
        $query =static::where('publish_at','>',$this->publish_at)
            ->where('publish_at','<',Carbon::now())
            ->where('is_draft',0)
            ->orderBy('publish_at','desc');
        if($tag){
            $query = $query->whereHas('tags',function($q)use($tag){
                $q->where('tag','=',$this->tag);
            });
        }
        return $query->first();
    }


}
