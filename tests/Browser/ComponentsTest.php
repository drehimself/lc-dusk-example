<?php

namespace Tests\Browser;

use App\Models\Post;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Components\CreatePostModal;

class ComponentsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_create_post_from_index_page()
    {
        $user = User::factory(['email' => 'user@user.com'])->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->within(new CreatePostModal, function ($browser) {
                    $browser->fillInPostDetails();
                });
        });
    }

    /** @test */
    public function can_create_post_from_show_page()
    {
        $post = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($post) {
            $browser->loginAs($post->user)
                ->visit(route('post.show', $post))
                ->within(new CreatePostModal, function ($browser) {
                    $browser->fillInPostDetails();
                });
        });
    }
}
