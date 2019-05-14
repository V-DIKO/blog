<?php

use Illuminate\Database\Seeder;
use App\Models\Articles;
use App\Models\Tag;
class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tags = Tag::all()->pluck('tag')->all();
        Articles::truncate();  // 先清理表数据

        DB::table('article_tag_pivot')->truncate();

        factory(Articles::class, 20)->create()->each(function($article)use($tags){
            if(mt_rand(1,100)<30){
                return ;
            }
            shuffle($tags);
            $articleTags = [$tags[0]];
            if (mt_rand(1, 100) <= 30) {
                $articleTags[] = $tags[1];
            }
            $article->syncTags($articleTags);
        });  // 一次填充20篇文章



    }
}
