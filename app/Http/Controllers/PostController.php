<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $posts = Post::with(['user', 'comments'])
        ->withCount('likes')
        ->latest()
        ->paginate(5);
        return view('pages.post.index', compact('posts'));

    }


    public function myPosts(Request $request)
    {
        $posts = Post::with(['user', 'comments'])
        ->whereUserId(Auth::id())
        ->withCount('likes')
        ->latest()
        ->paginate(5);
        return view('pages.post.index', compact('posts'));

    }




    public function create()
    {

        return view('pages.post.create');

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->toArray(),[
         'title'=>['required','string','min:1'],
         'description'=>['required','string','min:1'],
         'image'=>['nullable','image','mimes:png,jpg,jpeg'],
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                "errors"=>$validator->errors()
            ],400);
        }


        $post = new Post ;
        $post->user_id =$request->user()->id;

        $post->title =$request->title;
        $post->description =$request->description;

        if($request->hasFile('image')){
            $oldImage = $request->file('image');
            $newImage = $oldImage->hashName();

            $oldImage->move('uploads/posts-images/',$newImage);
            $post->image_name =$newImage;

        }
        $post->save();
        return response()->json([ 'success'=>true,"message"=> " Post Added SuccessFully"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = Post::with(['user', 'comments'=>function($q){
            return $q->with('user');
        }])
        ->withCount('likes')->findOrFail($id);

        $like = Like::wherePostId($post->id)
        ->whereUserId(Auth::id())->get();
         $isLiked =false;
        if($like->count() ){
            $isLiked =true;

        }
        // return $post;

        return view('pages.post.show' ,compact('post','isLiked'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {


        $post = Post::findOrFail($id);
        if($post->user_id != Auth::id()){
          return  abort(404);
        }
        return view('pages.post.edit' ,compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id != Auth::id()){
            return  abort(404);
        }
        $validator = Validator::make($request->toArray(),[
            'title'=>['required','string','min:1'],
            'description'=>['required','string','min:1'],
            'image'=>['nullable','image','mimes:png,jpg,jpeg'],
           ]);

           if($validator->fails()){
               return response()->json([
                   'success'=>false,
                   "errors"=>$validator->errors()
               ],400);
           }


           $post->user_id =$request->user()->id;

           $post->title =$request->title;
           $post->description =$request->description;

           if($request->hasFile('image')){

            if($post->image != null){
                Storage::disk('public_uploads')->delete('posts-images/'. $post->image_name);
            }
               $oldImage = $request->file('image');
               $newImage = $oldImage->hashName();

               $oldImage->move('uploads/posts-images/',$newImage);
               $post->image_name =$newImage;

           }
           $post->save();
           return response()->json([ 'success'=>true,"message"=> " Post Updated SuccessFully"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id != Auth::id()){
            return  abort(404);
        }
        if($post->image != null){
            Storage::disk('public_uploads')->delete('posts-images/'. $post->image_name);
        }

        $post->destroy();
           return response()->json([ 'success'=>true,"message"=> " Post Updated SuccessFully"], 201);



    }
}
