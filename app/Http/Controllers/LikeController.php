<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Li;

class LikeController extends Controller
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


    public function store(Request $request , $post_id)
    {
        $like = Like::wherePostId($post_id)
        ->whereUserId(Auth::id())->get();
        if($like->count() ){
            $like->first()->forceDelete();
            return ['deleted'];
        }

        $theLike =new Like ;
        $theLike->post_id =$post_id;
        $theLike->user_id =Auth::id();
        $theLike->save();


        return ['done'];

    }



}
