@extends('blog.layouts.master', [
  'title' => $article->title,
  'meta_description' => $article->meta_description ?? config('blog.description'),
])

@section('page-header')
    <header class="masthead" style="background-image: url('{{ page_image($article->page_image) }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ $article->title }}</h1>
                        <h2 class="subheading">{{ $article->subtitle }}</h2>
                        <span class="meta">
                            Posted on {{ $article->publish_at->format('Y-m-d') }}
                            @if ($article->tags->count())
                                in
                                {!! join(', ', $article->tagLinks()) !!}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {{-- 文章详情 --}}
                <article>
                    {!! $article->content_html !!}
                </article>

                <hr>

                {{-- 上一篇、下一篇导航 --}}
                <div class="clearfix">
                    {{-- Reverse direction --}}
                    @if ($tag && $tag->reverse_direction)
                        @if ($article->olderArticle($tag))
                            <a class="btn btn-primary float-left" href="{!! $article->olderArticle($tag)->url($tag) !!}">
                                ←
                                Previous {{ $tag->tag }} Post
                            </a>
                        @endif
                        @if ($article->newerArticle($tag))
                            <a class="btn btn-primary float-right" ref="{!! $article->newerArticle($tag)->url($tag) !!}">
                                Next {{ $tag->tag }} Post
                                →
                            </a>
                        @endif
                    @else
                        @if ($article->newerArticle($tag))
                            <a class="btn btn-primary float-left" href="{!! $article->newerArticle($tag)->url($tag) !!}">
                                ←
                                Newer {{ $tag ? $tag->tag : '' }} Post
                            </a>
                        @endif
                        @if ($article->olderArticle($tag))
                            <a class="btn btn-primary float-right" href="{!! $article->olderArticle($tag)->url($tag) !!}">
                                Older {{ $tag ? $tag->tag : '' }} Post
                                →
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop