<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use DatabaseMigrations;

    private $author;

    protected function setUp(): void
    {
      parent::setUp();

      $this->author = factory(\App\Author::class)->create([
        'first_name' => '太郎',
        'last_name' => '山田',
      ]);
    }

    public function testHasAValidFactory()
    {
      $this->assertInstanceOf(\App\Author::class, $this->author);
    }

    public function testFullName()
    {
      $this->assertEquals('太郎 山田', $this->author->fullName());
    }

    public function testBooks()
    {
      factory(\App\Book::class, 3)->create([
        'author_id' => $this->author->id
      ]);

      $this->assertEquals(3, $this->author->books()->count());
    }

    public function testSetImage()
    {
      Storage::fake('public');

      $author = factory(\App\Author::class)->create();

      // with null
      $image = null;
      $author->setImage($image);
      $this->assertNull($author->image_path);

      // with valid image
      $image = UploadedFile::fake()->image('dummy.jpg');
      $author->setImage($image);
      $this->assertNotNull($author->image_path);
      Storage::disk('public')->assertExists($author->image_path);

      // with another valid image
      $old_image_path = $author->image_path;
      $image = UploadedFile::fake()->image('another.png');
      $author->setImage($image);
      $this->assertNotEquals($old_image_path, $author->image_path);
      Storage::disk('public')->assertExists($author->image_path);
      Storage::disk('public')->assertMissing($old_image_path);
    }

    public function testDeleteImage()
    {
      Storage::fake('public');

      $author = factory(\App\Author::class)->create();
      $image = UploadedFile::fake()->image('dummy.png');
      $author->setImage($image);
      $image_path = $author->image_path;

      // with false
      $flag = false;
      $author->deleteImage($flag);
      $this->assertNotNull($author->image_path);
      Storage::disk('public')->assertExists($image_path);

      // with true
      $flag = true;
      $author->deleteImage($flag);
      $this->assertNull($author->image_path);
      Storage::disk('public')->assertMissing($image_path);
    }
}
