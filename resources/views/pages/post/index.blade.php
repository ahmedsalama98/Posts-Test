@extends('layouts.app')

@section('content')
<div class="container">

        <table class="table table-hover  table-bordered text-center">
          <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>

          </thead>
            <tbody>
                @forelse  ( $posts as $post)
                <tr data-id={{ $post->id }}>
                    <td> {{ $post->id  }} </td>
                    <td> <a href={{ route('post.show', $post->id ) }}>{{ $post->title }}</a></td>
                    <td> <a href={{ route('post.index',['user_id'=>$post->user->id]  ) }}>{{ $post->user->name }}</a></td>
                    <td>
                        <a href={{ route('post.show', $post->id )}}   class="btn btn-success">show</a>

                        @if ($post->user_id == Auth::user()->id)
                        <a href={{ route('post.edit', $post->id) }}   class="btn btn-primary">Edit</a>
                        <a href={{ route('post.destroy', $post->id) }}  class="btn btn-danger">Delete</a>
                        @else
                        <button class="btn btn-primary disabled">Edit</button>
                        <button  class="btn btn-danger disabled">Delete </button>
                        @endif

                    </td>
                </tr>


                @empty
                    <tr >
                        <td colspan="4">      No Posts Yet  <a href={{ route('post.create') }}  class="btn btn-success">Create New Post</a> </td>
                    </tr>
                @endforelse

            </tbody>
        </table>


        <div class="d-flex justify-content-center">
            {!! $posts->appends(request()->query())->links('pagination::bootstrap-4')!!}

        </div>



        <div class="d-flex justify-content-center">

            <a href={{ route('post.create') }}  class="btn btn-success">Create New Post</a>
        </div>

</div>
@endsection

