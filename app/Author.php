<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function fullName()
    {
      return $this->last_name . ' ' . $this->first_name;
    }
}
