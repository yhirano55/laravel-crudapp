<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLogin()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                    ->clickLink('ログイン')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('ログイン')
                    ->assertSee("こんにちは！ {$user->name} さん");
        });
    }
}
