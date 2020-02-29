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
        Storage::disk('public')->delete($author->image_path);
      });
    }

    protected $fillable = [
      'first_name',
      'last_name',
      'image_path',
    ];

    public function fullName()
    {
      return "{$this->first_name} {$this->last_name}";
    }

    public function books()
    {
      return $this->hasMany('App\Book');
    }
}
