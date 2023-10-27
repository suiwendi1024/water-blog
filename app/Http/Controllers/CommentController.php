<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index($commentable)
    {
        $comments = $commentable->comments()
        ->latest('id')
        ->withCount('likes')
        ->paginate()
        ->through(fn (Comment $comment) => $comment->append('is_liked'));

        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, $commentable)
    {
        $comment = $commentable->comment($request->body);

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
    }
}
