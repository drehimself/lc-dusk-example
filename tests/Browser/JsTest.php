<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class JsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function dad_joke_works()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@dad-joke')
                // ->pause(2000)
                ->waitFor('#dadJokeContainer')
                ->assertVisible('#dadJokeContainer');
        });
    }

    /** @test */
    public function double_click_works()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->doubleClick('@double-click')
                ->assertSee('Double clicked');
        });
    }

    /** @test */
    public function right_click_works()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->rightClick('@right-click')
                ->assertSee('Right clicked');
        });
    }

    /** @test */
    public function shortcut_keys_works()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->keys('@multiple-keys', ['{command}', 'b'])
                ->assertSee('Command + B pressed');
        });
    }
}
