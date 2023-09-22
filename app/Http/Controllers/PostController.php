<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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
        $this->authorize('viewAny', Post::class);
        return view('posts.index', [
            'posts' => Post::query()->with('user')->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $post = $request->user()->posts()->create($request->validated());
        return redirect()->route('posts.show', $post)->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.show', [
            'post' => $post->load('user'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', [
            'post' => $post->load('user'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->validated());
        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
