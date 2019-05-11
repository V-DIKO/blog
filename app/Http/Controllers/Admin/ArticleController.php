<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Jobs\PostFormFields;
use App\Models\Articles;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    protected $fieldList = [
        'title' => '',
        'subtitle' => '',
        'page_image' => '',
        'content' => '',
        'meta_description' => '',
        'is_draft' => "0",
        'publish_date' => '',
        'publish_time' => '',
        'layout' => 'blog.layouts.post',
        'tags' => [],
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.article.index',['articles'=>Articles::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $fields = $this->fieldList;
        $when = Carbon::now()->addHour();

        $fields['publish_date'] = $when->format('Y-m-d');
        $fields['publish_time'] = $when->format('g:i A');

        foreach($fields as $fieldName => $fieldValue){
            $fields[$fieldName] = old($fieldName,$fieldValue);
        }
        $data = array_merge(
         $fields,
            ['allTags'=> Tag::all()->pluck('tag')->all()]
        );
        return view('admin.article.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCreateRequest $request)
    {
        //
        $article = Articles::create($request->articlesFillData());
        $article->syncTags($request->get('tags', []));

        return redirect()->route('article.index')->with('success','新文章创建成功');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $fields = $this->fieldsFromModel($id,$this->fieldList);
        foreach ($fields as $fieldName => $fieldValue){
            $fields[$fieldName] = old($fieldName,$fieldValue);
        }

        $data = array_merge(
            $fields,
            ['allTags'=> Tag::all()->pluck('tag')->all()]
        );

        return view('admin.article.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, $id)
    {
        //
        $article = Articles::findOrFail($id);
        $article->fill($request->articlesFillData());
        $article->save();
        $article->syncTags($request->get('tags', []));

        if($request->action ==='continue' ){
            return redirect()->back()->with('success','文章已经被保存');
        }

        return redirect()->route('post.index')->with('success','文章已保存');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Articles::findOrFail($id);
        $article->tags()->detach();
        $article->delete();

        return redirect()->route('article.index','文章已删除');

    }

    public function fieldsFromModel($id,array $fields){
        $article = Articles::findOrFail($id);

        $fieldNames = array_keys(array_except($fields,['tags']));
        $fields = ['id'=>$id];
        foreach ($fieldNames as $field){
            $fields[$field] = $article->{$field};
        }

        $fields['tags'] = Tag::all()->pluck('tag')->all();
        return $fields;
    }
}
