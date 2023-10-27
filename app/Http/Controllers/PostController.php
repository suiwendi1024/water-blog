<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'create');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Post::latest('id')->withCount('comments', 'likes');

        if (request('category') > 1) {
            $query->whereCategoryId(request('category'));
        }

        $list = Post::withCount('comments')->latest('comments_count')->limit(10)->get()->append('href');

        $posts = $query->paginate()
            ->through(fn (Post $post) => $post->append(['beginning', 'href', 'is_liked']));

        return inertia('Posts/Index', [
            'list' => fn () => $list,
            'posts' => fn () => $posts,
            'categories' => fn () => Category::all(),
        ]);
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
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->loadCount('comments', 'likes')->append('is_liked');
        $post->author->loadCount('posts', 'receivedFollows');

        return inertia('Posts/Show', [
            'post' => fn () => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
