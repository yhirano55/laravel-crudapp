<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('会員登録')
                    ->type('name', '山田太郎')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('送信')
                    ->assertSee("こんにちは！ 山田太郎 さん");
        });
    }
}
