<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class CreatePostModal extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    public function fillInPostDetails($browser)
    {
        $browser->click('#modal-button')
            ->pause(1000) // dusk fails sometimes without this ??
            ->waitFor('#exampleModal', 1)
            ->type('title', 'New Title')
            ->type('content', 'New Content')
            ->click('@create-post-button')
            ->assertSee('Post was successfully created')
            ->assertSee('New Title')
            ->assertPathIs('/');
    }
}
