<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('cover')){
            $file=$request->file('cover');
            $imageName=time().'_'.$file->getClientOriginalName();
            $file->move(\public_path('cover/'),$imageName);

            $post = new Post([
                'title' => $request->title,
                'author' => $request->author,
                'body' => $request->body,
                'cover' => $imageName,
            ]);
            $post->save();
        }

        if($request->hasFile('images')){
            $files=$request->file('images');
            foreach($files as $file){
                $imageName=time().'_'.$file->getClientOriginalName();
                $request['post_id']=$post->id;
                $request['image']=$imageName;
                $file->move(\public_path('/images'),$imageName);
                Image::create($request->all());
            }
        }
        
        return redirect('/post');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::findOrFail($id);
        return view('edit')->with('posts',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts=Post::findOrFail($id);

        if(File::exists("cover/".$posts->cover)){
            File::delete("cover/".$posts->cover);
        }
        $images=Image::where("post_id",$posts->id)->get();
        foreach($images as $image){
            if(File::exists("images/".$image->image)){
                File::delete("images/".$image->image);
            }
        }
        $posts->delete();
        return back();
    }
}
