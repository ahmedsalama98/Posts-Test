@extends('layouts.app')

@section('content')
<div class="container">



        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="post">
                    <div class="post-head">
                        <div>
                            <h4>{{ $post->user->name }}</h4>
                            <span> {{ $post->created_at->format('M d , Y') }}</span>
                        </div>

                        @if($post->user_id == Auth::user()->id)
                        <div>
                            <a href={{ route('post.edit', $post->id) }}   class="btn btn-primary">Edit</a>
                            <a href={{ route('post.destroy', $post->id) }}  class="btn btn-danger">Delete</a>
                        </div>
                        @endif
                    </div>



                    <div class="post-body">
                        <div class="media">
                          <img src={{ $post->file_url }} alt="">
                        </div>

                        <h5>{{  $post->title  }}</h5>
                        <p> {{ $post->description }}</p>

                        <div class="likes" id="#likes">
                            <span data-count={{ $post->likes_count }} class="likes_count ">{{ $post->likes_count }} likes</span>

                            <form method="POST" action={{ route('like.store',$post->id) }}>
                                @csrf
                                @method('POST')
                            </form>
                            <span class="likes_btn" data-active={{ $isLiked ?"true":"false" }}></span>
                        </div>
                    </div>
                   </div>



                   <div class="add-comments">
                    <form id="add-comment" action={{ route('comment.store',$post->id) }} method="POST">
                        @csrf
                        @method('POST')

                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('Add comment') }}</label>

                            <div class="col-md-6">
                                <input id="comment_field" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{ old('comment') }}" required autocomplete="comment" autofocus>

                            </div>

                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Add Comment') }}
                                </button>
                            </div>
                        </div>

                    </form>
                   </div>


                   <div class="comments">


                    @forelse ( $post->comments as $comment)
                    <div class="comment">
                        <p>{{ $comment->user->name }}</p>
                        <span>{{ $comment->created_at->format('M d , Y')}}</span>

                        <p>{{ $comment->comment }}</p>
                    </div>
                    @empty

                    @endforelse
                   </div>
            </div>
        </div>
</div>
@endsection
