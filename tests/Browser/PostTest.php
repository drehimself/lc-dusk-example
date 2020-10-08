<?php

namespace Tests\Browser;

use App\Models\Post;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_view_index_of_posts()
    {
        $postA = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $postB = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($postA, $postB) {
            $browser->visit('/')
                ->assertSee($postA->title)
                ->assertSee('by '.$postA->user->name)
                ->assertSee($postB->title)
                ->assertSee('by '.$postB->user->name);
        });
    }

    /** @test */
    public function can_view_a_single_post()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visit(route('post.show', $post))
                ->assertSee($post->title)
                ->assertSee('By: '.$post->user->name)
                ->assertSee($post->content);
        });
    }

    /** @test */
    public function can_create_a_post()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs($post->user)
                ->visit('/')
                ->assertSee('Create Post')
                ->clickLink('Create Post')
                ->type('title', 'My First Post')
                ->type('content', 'My First Post content')
                ->click('@create-post')
                ->assertSee('Post was successfully created')
                ->assertSee('My First Post')
                ->assertPathIs('/');
        });
    }

    /** @test */
    public function can_edit_a_post()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs($post->user)
                ->visit('/')
                ->clickLink($post->title)
                ->assertSee('Edit Post')
                ->clickLink('Edit Post')
                ->type('title', 'My First Post edit')
                ->type('content', 'My First Post content edit')
                ->click('button[type="submit"]')
                ->assertSee('Post was updated successfully')
                ->assertSee('My First Post edit');
        });
    }

    /** @test */
    public function can_delete_a_post()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs($post->user)
                ->visit('/')
                ->clickLink($post->title)
                ->assertSee('Delete Post')
                ->click('button[type="submit"]')
                ->assertSee('Post was deleted successfully')
                ->assertDontSee($post->title);
        });
    }
}
