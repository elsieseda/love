<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Post;
use App\Models\Posts;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Database\Factories\PostsFactory;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Loader\Configurator\Traits\HostTrait;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;
    public function index()
    {
        
        $posts = Post::all();
        return $posts;


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $mem_id)
    {
        $this->validate($request, array(
            'description' => 'required',
            'content' => 'required',
          ));
          // decode token to  get id
          // or get id from front end

        
        
          $post = new Post();
          $mem= Member::find($mem_id);
          if (!$mem){
            return response()->json(['error' => 'Member not found'], 404);
          }else{
        
          $post->user_id = $mem_id;
          $post->content = $request->content;
          $post->description = $request->description;
          $post->save();

          return $this->success([
            'data' => $post,
            'message'=>'posts created'
        ]);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $mem_id, $id)
    {
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        }else{
            return Post::find($id);
        }
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $mem_id, $id)
    {
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        }else{
        $post=Post::find($id);
        $post->update($request->all());
        return $post;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mem_id, $id)
    {
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        } else{return Post::destroy($id);}
    }

}
