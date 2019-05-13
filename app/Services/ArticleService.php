<?php
/**
 *
 * User: lwx
 * Date: 2019/5/13
 * Time: 17:24
 *
 */

namespace App\Services;

use App\Models\Articles;
use App\Models\Tag;
use Carbon\Carbon;

class ArticleService
{
    protected $tag;

    public function __construct($tag){
        $this->tag = $tag;
    }

    public function lists(){
        if($this->tag){
            return $this->tag = tagIndexData($this->tag);
        }
        return $this->normalIndexData();
    }

    protected function normalIndexData(){
        $articles = Articles::with('tags')
            ->where('publish_at','<',Carbon::now())
            ->where('is_draft',0)
            ->orderBy('publish_at','desc')
            ->simplePaginate(config('blog.article_per_page'));

        return [
            'title'=>config('blog.title'),
            'subtitle'=>config('blog.subtitle'),
            'articles'=>$articles,
            'page_image'=>config('blog.page_image'),
            'meta_description'=>config('blog.description'),
            'reverse_direction'=>false,
            'tag'=>null
        ];
    }

   protected function tagIndexData($tag){
        $tag = Tags::where('tag',$tag)->fisrtOrfail();
        $reverse_direction = (bool)$tag->reverse_direction;

        $articles = Article::where('publish_at','<',Carbon::now())
            ->whereHas(function($q)use($tag){
                $q->where('tag','=',$tag->tag);
            })
            ->where('is_draft',0)
            ->orderBy('publish_at','desc')
            ->simplePaginate(config('blog.article_per_page'));

        $articles->appends('tag',$tag->tag);

        $page_image = $tag->page_image?:config('blog.per_image');
        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'posts' => $articles,
            'page_image' => $page_image,
            'tag' => $tag,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag->meta_description ?: config('blog.description'),
        ];

   }


}