<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', [
            'posts' => Post::latest()->paginate(10),
        ]);
    }
}
