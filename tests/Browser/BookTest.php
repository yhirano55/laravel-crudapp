<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BookTest extends DuskTestCase
{
  use DatabaseMigrations;

  public function testBooks()
  {
    $author = factory(\App\Author::class)->create();

    $this->browse(function (Browser $browser) use ($author) {
      $browser->visit('/books')
              ->clickLink('Create new book')
              ->type('title', '吾輩は猫である')
              ->type('summary', 'どこで生れたか頓と見當がつかぬ。何でも薄暗いじめじめした所でニヤーニヤー泣いて居た事丈は記憶して居る。')
              ->type('price', 350)
              ->select('author_id', $author->id)
              ->press('Create Book')
              ->assertSee('Book was successfully created.')
              ->assertSee('吾輩は猫である')
              ->clickLink('Back')
              ->assertSeeIn('td.book-col-title', '吾輩は猫である')
              ->assertSeeIn('td.book-col-price', '350')
              ->assertSeeIn('td.book-col-author', $author->fullName())
              ->clickLink('Edit')
              ->type('title', '坊っちゃん')
              ->type('summary', '松山中学在任当時の体験を背景とした初期の代表作。')
              ->type('price', 500)
              ->press('Update Book')
              ->assertSee('Book was successfully updated.')
              ->assertSee('坊っちゃん')
              ->clickLink('Back')
              ->assertSeeIn('td.book-col-title', '坊っちゃん')
              ->assertSeeIn('td.book-col-price', '500')
              ->press('Delete')
              ->assertSee('Book was successfully deleted.');
    });
  }
}
