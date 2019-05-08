<html>
    <head>
        <title>{{config('blog.title')}}</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body>
    <div class="container">
        <h1>{{config('blog.title')}}</h1>
        <h5>Page {{$article->currentPage()}} of {{$article->lastPage()}}</h5>
        <hr>
        <ul>
            @foreach($article as $item)
                <li>
                    <a href="{{route('blog.detail',['slug'=>$item->slug])}}">{{$item->title}}</a>
                    <em>{{$item->publish_time}}</em>
                    <p>{{str_limit($item->content)}}</p>
                </li>
            @endforeach
        </ul>
        <hr>
        {!! $article->render() !!}
    </div>
    </body>
</html>