<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Tag;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $articleService = new ArticleService($tag);
        $data = $articleService->lists();
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        return view($layout, $data);
    }

    public function detail($slug, Request $request)
    {
        $article = Articles::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::where('tag', $tag)->firstOrFail();
        }
        return view($article->layout, compact('article', 'tag'));
    }
}