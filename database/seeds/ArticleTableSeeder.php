<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();  // 先清理表数据
        factory(Article::class, 20)->create();  // 一次填充20篇文章
    }
}
