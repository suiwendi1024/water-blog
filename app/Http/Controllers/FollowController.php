<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFollowRequest;
use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $followee)
    {
        $followee->follow();
        return response()->json(['message' => '已关注！']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFollowRequest $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $followee)
    {
        $followee->unfollow();
        return response()->json(['message' => '已取消关注！']);
    }
}
