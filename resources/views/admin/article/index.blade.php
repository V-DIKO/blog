@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>文章 <small>» 列表</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/article/create" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 创建新文章
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table id="posts-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>发布时间</th>
                        <th>标题</th>
                        <th>副标题</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td data-order="{{ $article->publish_at->timestamp }}">
                                {{ $article->publish_at->format('Y-m-d g:ia') }}
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->subtitle }}</td>
                            <td>
                                <a href="/admin/article/{{ $article->id }}/edit" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                                <a href="/blog/{{ $article->slug }}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-eye"></i> 查看
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $("#posts-table").DataTable({
                order: [[0, "desc"]]
            });
        });
    </script>
@stop