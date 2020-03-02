<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use Illuminate\Validation\ValidationException;

class AuthorTest extends TestCase
{
    use DatabaseMigrations;

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
      Storage::fake('public');
      $image = UploadedFile::fake()->image('dummy.png');

      $response = $this->post('/authors', [
        'first_name' => 'Taro',
        'last_name' => 'Yamada',
        'image' => $image,
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
        ->assertSee('Taro Yamada')
        ->assertSee($author->image_path);
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
      Storage::fake('public');
      $image = UploadedFile::fake()->image('dummy.png');

      $author = factory(\App\Author::class)->create();
      $author->setImage($image);

      $response = $this->patch("/authors/{$author->id}", [
        'first_name' => 'Taro',
        'last_name' => 'Yamada',
        'image_delete_flag' => '1',
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
        ->assertSee('Taro Yamada')
        ->assertSee('Image Not Found');
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

    // TODO: 内容のチェック
    public function testExport()
    {
      $author = factory(\App\Author::class)->create();

      $response = $this->get('/authors/export');
      $response->assertStatus(200);
    }
}
