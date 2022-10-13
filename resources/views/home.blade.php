@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Test') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href={{ route('post.me') }} class="btn  btn-info ">My Posts</a>

                    <a href={{ route('post.index') }} class="btn  btn-primary ">All Posts</a>

                    <a href={{ route('post.create') }} class="btn  btn-success">Create New  Post</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
