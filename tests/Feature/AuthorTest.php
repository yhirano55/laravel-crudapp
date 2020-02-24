<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Validation\ValidationException;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
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

    public function test_create()
    {
      $response = $this->get('/authors/create');
      $response->assertStatus(200);
    }

    public function test_store_with_valid()
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
        ->assertSee('Yamada Taro');
    }

    public function test_store_with_invalid()
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

    public function test_edit()
    {
      $author = factory(\App\Author::class)->create();
      $response = $this->get("/authors/{$author->id}/edit");
      $response->assertStatus(200);
    }

    public function test_update_with_valid()
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
        ->assertSee('Yamada Taro');
    }

    public function test_update_with_invalid()
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

    public function test_destroy_with_valid()
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
