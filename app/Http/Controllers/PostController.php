<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function post_order(Request $request)
    {
        $post = Post::orderBy('position', 'asc')->get();

        return view('post.post_order', compact('post'));

    }
    public function post_order_change(Request $request)
    {
    $data = $request->input('order');
        foreach ($data as $index => $id) {
            Post::where('id', $id)->update(['position' => $index]);
        }
        return  response()->json([

            'message' => 'Post Order changed successfully.',

            'alert-type' => 'success'

        ]);
    //return response()->json(['success' => $data]);
    }
}
