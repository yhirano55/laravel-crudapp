<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private $book;

    protected function setUp(): void
    {
      parent::setUp();

      $this->book = factory(\App\Author::class)->create();
    }

    // @test
    public function test_has_a_valid_factory()
    {
      $book = factory(\App\Book::class)->create();
      $this->assertInstanceOf(\App\Book::class, $book);
    }
}
