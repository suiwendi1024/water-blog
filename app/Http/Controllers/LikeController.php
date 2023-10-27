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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($likeable)
    {
        $likeable->unlike();
    }
}
