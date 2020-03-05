<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
  /**
   * @var array
   **/
  protected $fillable = [
    'title',
    'summary',
    'price',
    'author_id',
  ];

  public function author(): BelongsTo
  {
    return $this->belongsTo(Author::class);
  }
}
