<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
      'first_name',
      'last_name',
    ];

    public function fullName()
    {
      return "{$this->last_name} {$this->first_name}";
    }

    public function books()
    {
      return $this->hasMany('App\Book');
    }
}
