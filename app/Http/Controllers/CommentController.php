<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        // Kreiraj novi komentar
        $comment = new Comment([
            'comment' => $request->comment,
            'user_id' => Auth::id(), // ID trenutnog korisnika
        ]);

        $post->comments()->save($comment);

        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::id() !== $comment->post->user_id && Auth::user()->role!="admin") {
            return redirect()->back()->with('error', 'You do not have permission to delete this comment.');
        }
        

    
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
