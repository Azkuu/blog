<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function show(Post $post)
    {
        // return dd($post);
        return view('blog.show')->with('post', $post);
    }
}
