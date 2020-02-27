<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Validation\ValidationException;

class BookTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex()
    {
      $book = factory(\App\Book::class)->create();

      $response = $this->get('/books');
      $response
        ->assertStatus(200)
        ->assertSee('Books List')
        ->assertSee($book->id)
        ->assertSee($book->title)
        ->assertSee($book->price)
        ->assertSee($book->author->fullName());
    }

    public function testCreate()
    {
      $response = $this->get('/books/create');
      $response->assertStatus(200);
    }

    public function testStoreWithValid()
    {
      $author = factory(\App\Author::class)->create();
      $response = $this->post('/books', [
        'title' => 'Book Title',
        'summary' => 'Book Summary',
        'price' => 3000,
        'author_id' => $author->id,
      ]);
      $book = \App\Book::first();
      $response
        ->assertStatus(302)
        ->assertHeader('Location', url("/books/{$book->id}"));
      $response = $this->get("/books/{$book->id}");
      $response
        ->assertStatus(200)
        ->assertSee('Book was successfully created.')
        ->assertSee("Book (id: {$book->id})")
        ->assertSee($book->id)
        ->assertSee('Book Title')
        ->assertSee('Book Summary')
        ->assertSee('3000');
    }

    public function testStoreWithInvalid()
    {
      $this->withoutExceptionHandling();

      try {
        $author_id = $this->faker->randomNumber(5);
        $response = $this->post('/books', [
          'title' => null,
          'summary' => null,
          'price' => null,
          'author_id' => $author_id,
        ]);
      } catch (ValidationException $e) {
        $this
          ->assertEquals(
            'The title field is required.',
            $e->validator->errors()->first('title')
          );
        $this
          ->assertEquals(
            'The summary field is required.',
            $e->validator->errors()->first('summary')
          );
        $this
          ->assertEquals(
            'The price field is required.',
            $e->validator->errors()->first('price')
          );
        $this
          ->assertEquals(
            'The selected author id is invalid.',
            $e->validator->errors()->first('author_id')
          );
      }
    }

    public function testEdit()
    {
      $book = factory(\App\Book::class)->create();
      $response = $this->get("/books/{$book->id}/edit");
      $response->assertStatus(200);
    }

    public function testUpdateWithValid()
    {
      $book = factory(\App\Book::class)->create();
      $author = factory(\App\Author::class)->create();
      $response = $this->patch("/books/{$book->id}", [
        'title' => 'Book Title',
        'summary' => 'Book Summary',
        'price' => 3000,
        'author_id' => $author->id,
      ]);
      $response
        ->assertStatus(302)
        ->assertHeader('Location', url("/books/{$book->id}"));
      $response = $this->get("/books/{$book->id}");
      $response
        ->assertStatus(200)
        ->assertSee('Book was successfully updated.')
        ->assertSee("Book (id: {$book->id})")
        ->assertSee($book->id)
        ->assertSee('Book Title')
        ->assertSee('Book Summary')
        ->assertSee('3000');
    }

    public function testUpdateWithInvalid()
    {
      $this->withoutExceptionHandling();

      $book = factory(\App\Book::class)->create();
      $author_id = $this->faker->randomNumber(5);

      try {
        $response = $this->patch("/books/{$book->id}", [
          'title' => null,
          'summary' => null,
          'price' => null,
          'author_id' => $author_id,
        ]);
      } catch (ValidationException $e) {
        $this
          ->assertEquals(
            'The title field is required.',
            $e->validator->errors()->first('title')
          );
        $this
          ->assertEquals(
            'The summary field is required.',
            $e->validator->errors()->first('summary')
          );
        $this
          ->assertEquals(
            'The price field is required.',
            $e->validator->errors()->first('price')
          );
        $this
          ->assertEquals(
            'The selected author id is invalid.',
            $e->validator->errors()->first('author_id')
          );
      }
    }

    public function testDestroyWithValid()
    {
      $book = factory(\App\Book::class)->create();
      $response = $this->delete("/books/{$book->id}");
      $response
        ->assertStatus(302)
        ->assertHeader('Location', url("/books"));
      $response = $this->get("/books");
      $response
        ->assertStatus(200)
        ->assertSee('Book was successfully deleted.');
    }

    // TODO: 内容のチェック
    public function testExport()
    {
      $book = factory(\App\Book::class)->create();

      $response = $this->get('/books/export');
      $response->assertStatus(200);
    }
}
