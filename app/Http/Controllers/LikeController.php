<?php

namespace App\Http\Controllers;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($likeable)
    {
        $likeable->like();
        return response()->json(['message' => '已点赞！']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($likeable)
    {
        $likeable->unlike();
        return response()->json(['message' => '已取消点赞！']);
    }
}
