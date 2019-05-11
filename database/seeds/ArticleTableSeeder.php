<?php

use Illuminate\Database\Seeder;
use App\Models\Articles;
class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articles::truncate();  // 先清理表数据
        factory(Articles::class, 20)->create();  // 一次填充20篇文章
    }
}
