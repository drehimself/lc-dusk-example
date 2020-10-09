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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
