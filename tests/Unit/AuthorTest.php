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
      $this->assertEquals('山田 太郎', $this->author->fullName());
    }
}
