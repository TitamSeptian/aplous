<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->value('#uname', 'admin')
                ->value('#pwd', '123qwe123')
                ->press('Masuk')
                ->click('button[type="submit"]')
                ->waitFor('body', 2)
                // make expect
                ->assertPathIs(env('APP_URL') . '/dashboard');
        });
    }
}
