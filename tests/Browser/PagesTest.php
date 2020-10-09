<?php

namespace Tests\Browser;

use App\Models\Post;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PagesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_create_a_post()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit(new Login)
                ->fillInLoginForm($post->user->email, 'password')
                ->visit('/')
                ->assertSee('Create Post')
                ->clickLink('Create Post')
                ->type('title', 'My First Post')
                ->type('content', 'My First Post content')
                ->click('@create-post')
                ->assertSee('Post was successfully created')
                ->assertSee('My First Post')
                ->assertPathIs('/')
                ->click('#navbarDropdown')
                ->clickLink('Logout')
                ->assertSee('Posts');
        });
    }

    /** @test */
    public function can_edit_a_post()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit(new Login)
                ->fillInLoginForm($post->user->email, 'password')
                ->visit('/')
                ->clickLink($post->title)
                ->assertSee('Edit Post')
                ->clickLink('Edit Post')
                ->type('title', 'My First Post edit')
                ->type('content', 'My First Post content edit')
                ->click('button[type="submit"]')
                ->assertSee('Post was updated successfully')
                ->assertSee('My First Post edit')
                ->click('#navbarDropdown')
                ->clickLink('Logout')
                ->assertSee('Posts');
        });
    }
}
