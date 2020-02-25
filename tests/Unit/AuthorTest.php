<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    private $author;

    protected function setUp(): void
    {
      parent::setUp();

      $this->author = factory(\App\Author::class)->create([
        'first_name' => '太郎',
        'last_name' => '山田',
      ]);
    }

    // @test
    public function test_has_a_valid_factory()
    {
      $this->assertInstanceOf(\App\Author::class, $this->author);
    }

    // @test
    public function test_first_name()
    {
      $this->assertEquals('太郎', $this->author->first_name);
    }

    // @test
    public function test_last_name()
    {
      $this->assertEquals('山田', $this->author->last_name);
    }

    // @test
    public function test_fullName()
    {
      $this->assertEquals('太郎 山田', $this->author->fullName());
    }

    // @test
    public function test_books()
    {
      factory(\App\Book::class, 3)->create([
        'author_id' => $this->author->id
      ]);

      $this->assertEquals(3, $this->author->books()->count());
    }
}
