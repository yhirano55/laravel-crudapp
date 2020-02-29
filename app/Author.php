<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Author extends Model
{
    protected static function boot()
    {
      parent::boot();

      static::deleting(function ($author) {
        $author->purgeImage();
      });
    }

    protected $fillable = [
      'first_name',
      'last_name',
    ];

    public function fullName()
    {
      return "{$this->first_name} {$this->last_name}";
    }

    public function books()
    {
      return $this->hasMany('App\Book');
    }

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

    public function deleteImage($flag) {
      if (empty($flag)) {
        return null;
      }

      $this->purgeImage();
      $this->image_path = null;
    }

    protected function uploadImage($image)
    {
      $filename = time() . '.' . $image->getClientOriginalExtension();
      return $image->storeAs('author/images', $filename, 'public');
    }

    protected function purgeImage()
    {
      return Storage::disk('public')->delete($this->image_path);
    }
}
