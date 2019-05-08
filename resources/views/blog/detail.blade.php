<html>
<head>
    <title>{{$article->title}}</title>
    <link rel="stylesheet" href="{{asset('css\app.css')}}">
</head>
<body>
<div class="container">
    <h1>{{$article->title}}</h1>
    <h5>{{$article->content}}</h5>
    <hr>
    <button class="btn btn-primary" onclick="history.go(-1)">
        << Back
    </button>
</div>
</body>
</html>