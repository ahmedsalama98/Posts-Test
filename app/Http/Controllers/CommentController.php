<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{


    public function store(Request $request, $post_id)
    {

        $validator = Validator::make($request->toArray(),[
            'comment'=>['required','string','min:1'],
           ]);

           if($validator->fails()){
               return response()->json([
                   'success'=>false,
                   "errors"=>$validator->errors()
               ],400);
           }


           $comment = new Comment ;
           $comment->user_id =Auth::id();

           $comment->comment =$request->comment;
           $comment->post_id =$post_id;

           $comment->save();

           return response()->json([ 'success'=>true,"message"=> " comment Added SuccessFully","data"=>$comment], 201);



    }

}
