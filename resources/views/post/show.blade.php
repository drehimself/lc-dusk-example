@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post</div>

                <div class="card-body">
                    @if (session('success_message'))
                        <div class="alert alert-success">
                            {{ session('success_message') }}
                        </div>
                    @endif

                    <h2>{{ $post->title }}</h2>
                    <div>By: {{ $post->user->name }}</div>

                    <div class="mt-5">
                        {{ $post->content }}
                    </div>

                    @if ($post->user_id === auth()->id())
                        <div class="mt-4">
                            <a href="{{ route('post.edit', $post) }}" class="btn btn-primary">Edit Post</a>
                        </div>

                        <div class="mt-2">
                            <form action="{{ route('post.delete', $post) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete Post</button>
                            </form>
                        </div>
                    @endif

                    @auth
                        <div class="mt-4">
                            <button dusk="modal-button" id="modal-button" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">
                                Create Post Modal
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
