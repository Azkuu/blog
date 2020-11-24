<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Tag;
use App\Post;
use App\Category;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        $image = $request->image->store('posts');

        $post =  Post::create([

            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' =>  $image,
            'published_at' => $request->published_at,
            'category_id' =>  $request->category,
            'user_id' => auth()->user()->id

        ]);

        if ($request->tags) {
            $post->tags()->attach($request->tags); //attach sebab many to many
        }

        session()->flash('success', 'Post created successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all()); //sini dia bagi drpde depan
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        $data =  $request->only(['title', 'description','published_at', 'content']);
        //check new image
        if ($request->hasFile('image')) {
            //upload it
            $image = $request->image->store('posts');
            // delete oold one
            $post->deleteImage();

            $data['image'] = $image;
        }
        //sini dia check tags form ade update baru tak then dia sync la itu macam
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        //update the atrribute
        $post->update($data);

        //flash the message
        session()->flash('success', 'Post updated successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //tak pakai post sebab nie buat sendiri tgok kat web route
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if ($post->trashed()) {
            $post->deleteImage(); // untuk delete dalam storage

            $post->forceDelete();
        } else {
            $post->delete();
        }

        session()->flash('success', 'Post Deleted successfully');

        return redirect(route('posts.index'));
    }


    /**
       * Display list of all trashed post
       *

       * @return \Illuminate\Http\Response
       */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed); //cara withposts sama macam yg kat atas untuk vairable front end
    }


    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post Restored successfully');

        return redirect()->back();
    }
}
