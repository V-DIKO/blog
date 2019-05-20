<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    //
    public function index(Request $request){
        $articles = Articles::orderby('publish_at','desc')->simplePaginate(5);
        $data = [];
        foreach ($articles as $article){
            $item = [] ;
            $item['id'] = $article->id;
            $item['title'] = $article->title;
            $item['views'] = rand(1000,9999);
            $item['summary'] = $article->subtitle;
            $item['thumb'] = config('blog.uploads.webpath').'/'.$article->page_image;
            $item['posted_at'] = $article->publish_at->format('Y-m-d');
            $data[] = $item;
        }
        $response = [
            'message'=>'success',
            'data'=>$data
        ];
        return response()->json($response);
    }

    public function detail($id){
        $article = Articles::findOrFail($id);
        return new ArticleResource($article);
    }


}
