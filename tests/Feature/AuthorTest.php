<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Validation\ValidationException;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
      $author = factory(\App\Author::class)->create();

      $response = $this->get('/authors');
      $response
        ->assertStatus(200)
        ->assertSee('Authors List')
        ->assertSee($author->id)
        ->assertSee($author->first_name)
        ->assertSee($author->last_name)
        ->assertSee($author->fullName());
    }

    public function testCreate()
    {
      $response = $this->get('/authors/create');
      $response->assertStatus(200);
    }

    public function testStoreWithValid()
    {
      $response = $this->post('/authors', [
        'first_name' => 'Taro',
        'last_name' => 'Yamada',
      ]);
      $author = \App\Author::first();
      $response
        ->assertStatus(302)
        ->assertHeader('Location', url("/authors/{$author->id}"));
      $response = $this->get("/authors/{$author->id}");
      $response
        ->assertStatus(200)
        ->assertSee('Author was successfully created.')
        ->assertSee("Author (id: {$author->id})")
        ->assertSee($author->id)
        ->assertSee('Taro Yamada');
    }

    public function testStoreWithInvalid()
    {
      $this->withoutExceptionHandling();

      try {
        $response = $this->post('/authors', [
          'first_name' => null,
          'last_name' => null,
        ]);
      } catch (ValidationException $e) {
        $this
          ->assertEquals(
            'The first name field is required.',
            $e->validator->errors()->first('first_name')
          );
        $this
          ->assertEquals(
            'The last name field is required.',
            $e->validator->errors()->first('last_name')
          );
      }
    }

    public function testEdit()
    {
      $author = factory(\App\Author::class)->create();
      $response = $this->get("/authors/{$author->id}/edit");
      $response->assertStatus(200);
    }

    public function testUpdateWithValid()
    {
      $author = factory(\App\Author::class)->create();
      $response = $this->patch("/authors/{$author->id}", [
        'first_name' => 'Taro',
        'last_name' => 'Yamada',
      ]);
      $response
        ->assertStatus(302)
        ->assertHeader('Location', url("/authors/{$author->id}"));
      $response = $this->get("/authors/{$author->id}");
      $response
        ->assertStatus(200)
        ->assertSee('Author was successfully updated.')
        ->assertSee("Author (id: {$author->id})")
        ->assertSee($author->id)
        ->assertSee('Taro Yamada');
    }

    public function testUpdateWithInvalid()
    {
      $author = factory(\App\Author::class)->create();
      $this->withoutExceptionHandling();

      try {
        $response = $this->patch("/authors/{$author->id}", [
          'first_name' => null,
          'last_name' => null,
        ]);
      } catch (ValidationException $e) {
        $this
          ->assertEquals(
            'The first name field is required.',
            $e->validator->errors()->first('first_name')
          );
        $this
          ->assertEquals(
            'The last name field is required.',
            $e->validator->errors()->first('last_name')
          );
      }
    }

    public function testDestroyWithValid()
    {
      $author = factory(\App\Author::class)->create();
      $response = $this->delete("/authors/{$author->id}");
      $response
        ->assertStatus(302)
        ->assertHeader('Location', url("/authors"));
      $response = $this->get("/authors");
      $response
        ->assertStatus(200)
        ->assertSee('Author was successfully deleted.');
    }
}
