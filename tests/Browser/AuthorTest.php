<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthorTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAuthors()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/authors')
                    ->clickLink('Create new author')
                    ->type('first_name', '太郎')
                    ->type('last_name', '山田')
                    ->press('Create Author')
                    ->assertSee('Author was successfully created.')
                    ->assertSee('太郎 山田')
                    ->clickLink('Back')
                    ->assertSeeIn('td.author-col-first_name', '太郎')
                    ->assertSeeIn('td.author-col-last_name', '山田')
                    ->assertSeeIn('td.author-col-fullName', '太郎 山田')
                    ->clickLink('Edit')
                    ->type('first_name', '花子')
                    ->press('Update Author')
                    ->assertSee('Author was successfully updated.')
                    ->assertSee('花子 山田')
                    ->clickLink('Back')
                    ->assertSeeIn('td.author-col-first_name', '花子')
                    ->assertSeeIn('td.author-col-last_name', '山田')
                    ->assertSeeIn('td.author-col-fullName', '花子 山田')
                    ->press('Delete')
                    ->assertSee('Author was successfully deleted.');
        });
    }
}
