<?php

namespace Models;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_insert_data(): void
    {
        $data = Article::factory()->make()->toArray();

        Article::create($data);

        $this->assertDatabaseHas('articles', $data);
    }

    public function test_article_has_authors(): void
    {
        $count = rand(0,10);

        $data = Article::factory()->hasAuthors($count)->create();

        $this->assertCount($count,$data->authors);
    }
}
