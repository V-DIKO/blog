@extends('blog.layouts.master')

@section('page-header')
    <header class="masthead" style="background-image: url('{{ page_image($page_image) }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>{{ $title }}</h1>
                        <span class="subheading">{{ $subtitle }}</span>
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
                {{-- 文章列表 --}}
                @foreach ($articles as $article)
                    <div class="article-preview">
                        <a href="{{ $article->url($tag) }}">
                            <h2 class="post-title">{{ $article->title }}</h2>
                            @if ($article->subtitle)
                                <h3 class="article-subtitle">{{ $article->subtitle }}</h3>
                            @endif
                        </a>
                        <p class="post-meta">
                            Posted on {{ $article->publish_at->format('Y-m-d') }}
                            @if ($article->tags->count())
                                in
                                {!! join(', ', $article->tagLinks()) !!}
                            @endif
                        </p>
                    </div>
                    <hr>
                @endforeach

                {{-- 分页 --}}
                <div class="clearfix">
                    {{-- Reverse direction --}}
                    @if ($reverse_direction)
                        @if ($articles->currentPage() > 1)
                            <a class="btn btn-primary float-left" href="{!! $articles->url($articles->currentPage() - 1) !!}">
                                ←
                                Previous {{ $tag->tag }} Posts
                            </a>
                        @endif
                        @if ($articles->hasMorePages())
                            <a class="btn btn-primary float-right" ref="{!! $articles->nextPageUrl() !!}">
                                Next {{ $tag->tag }} Posts
                                →
                            </a>
                        @endif
                    @else
                        @if ($articles->currentPage() > 1)
                            <a class="btn btn-primary float-left" href="{!! $articles->url($articles->currentPage() - 1) !!}">
                                ←
                                Newer {{ $tag ? $tag->tag : '' }} Posts
                            </a>
                        @endif
                        @if ($articles->hasMorePages())
                            <a class="btn btn-primary float-right" href="{!! $articles->nextPageUrl() !!}">
                                Older {{ $tag ? $tag->tag : '' }} Posts
                                →
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop