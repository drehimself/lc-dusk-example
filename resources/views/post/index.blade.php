@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts</div>

                <div class="card-body">
                    @if (session('success_message'))
                        <div class="alert alert-success">
                            {{ session('success_message') }}
                        </div>
                    @endif

                    <ul>
                        @forelse ($posts as $post)
                            <li>
                                <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                                <span> by {{ $post->user->name }}</span>
                            </li>
                        @empty
                            <li>No posts found</li>
                        @endforelse
                    </ul>

                    @auth
                        <div class="mt-4">
                            <a href="{{ route('post.create') }}" class="btn btn-primary">Create Post</a>
                        </div>

                        <div class="mt-4">
                            <button dusk="modal-button" id="modal-button" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Create Post Modal
                            </button>
                        </div>
                    @endauth

                    <div class="my-5" x-data="{
                        dadJoke: null
                    }">
                        <button dusk="dad-joke" class="btn btn-secondary" @click="
                            axios.get('https://icanhazdadjoke.com', {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                                .then(response => {
                                    setTimeout(() => {
                                        dadJoke = response.data.joke
                                    }, 1000)
                                })
                        ">
                            Get Dad Joke
                        </button>
                        <div class="mt-4">
                            <p id="dadJokeContainer" x-show="dadJoke" x-text="dadJoke"></p>
                        </div>
                    </div>

                    <hr>

                    <div class="my-5" x-data="{
                        isVisible: false
                    }">

                        <div dusk="double-click" class="btn btn-primary" @dblclick="isVisible = !isVisible">
                            Double click me
                        </div>

                        <div x-show="isVisible" class="mt-4">
                            Double clicked!
                        </div>
                    </div>

                    <hr>

                    <div class="my-5" x-data="{
                        isVisible: false
                    }">

                        <div dusk="right-click" class="btn btn-primary" @contextmenu.prevent="isVisible = !isVisible">
                            Right click me
                        </div>

                        <div x-show="isVisible" class="mt-4">
                            Right clicked!
                        </div>
                    </div>

                    <hr>

                    <div class="my-5" x-data="{
                        isVisible: false
                    }">

                        <input dusk="multiple-keys" type="text" @keydown="
                            if (event.metaKey && event.which === 66) {
                                isVisible = !isVisible
                            }
                        ">
                        <div x-show="isVisible" class="mt-4">
                            Command + B pressed
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
