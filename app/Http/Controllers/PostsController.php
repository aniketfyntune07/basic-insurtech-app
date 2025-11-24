<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostsController extends Controller
{
    public function index(){
          $response = Http::timeout(10)->get('https://jsonplaceholder.typicode.com/posts');

    if ($response->failed()) {
        // pass an empty array and an error message to the view
        return view('posts.index', ['posts' => [], 'error' => 'Failed to fetch posts.']);
    }
        $posts = $response->json();

        return view ('posts.index', compact('posts'));
    }
}
