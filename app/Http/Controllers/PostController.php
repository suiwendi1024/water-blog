<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('index', 'create');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Post::latest('id');

        if (request('category') > 1) {
            $query->whereCategoryId(request('category'));
        }

        $posts = $query->paginate()->through(fn (Post $post) => $post->append(['beginning', 'href']));

        return inertia('Posts/Index', [
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
