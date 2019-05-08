<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(){
        $article = Article::where('publish_at','<=',Carbon::now())
            ->orderBy('publish_at','desc')
            ->paginate(config('blog.article_per_page'));

        return view('blog.index',compact('article'));
    }

    public function detail($slug){
        $article = Article::where('slug',$slug)->firstOrFail();
        return view('blog.detail',compact('article'));
    }
}
