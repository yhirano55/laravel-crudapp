<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;

class Author extends Model
{
    protected static function boot()
    {
      parent::boot();

      static::deleting(function ($author) {
        $author->purgeImage();
      });
    }

    /**
     * @var array
     **/
    protected $fillable = [
      'first_name',
      'last_name',
    ];

    public function fullName(): string
    {
      return "{$this->first_name} {$this->last_name}";
    }

    public function books(): HasMany
    {
      return $this->hasMany(Book::class);
    }

    /**
     * @param ?UploadedFile $image
     * @return ?void
     **/
    public function setImage($image)
    {
      if (empty($image)) {
        return null;
      }

      if (!empty($this->image_path)) {
        $this->purgeImage();
      }
      $this->image_path = $this->uploadImage($image);
    }

    /**
     * @param bool $flag
     * @return ?void
     **/
    public function deleteImage($flag) {
      if (empty($flag)) {
        return null;
      }

      $this->purgeImage();
      $this->image_path = null;
    }

    /**
     * @param ?UploadedFile $image
     * @return string|false
     **/
    protected function uploadImage($image)
    {
      $filename = microtime(true) . '.' . $image->getClientOriginalExtension();
      return $image->storeAs('author/images', $filename, 'public');
    }

    protected function purgeImage(): bool
    {
      return Storage::disk('public')->delete($this->image_path);
    }
}
