<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
   
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return response()->json($posts);
    }

    
    public function create()
    {
        return Inertia::render('NewPost');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => 'Post created successfully.'], 201);
    }

    
    public function show($id)
{
    $post = Post::with(['user', 'comments.user'])->findOrFail($id);
    $currentUser = Auth::user(); 
    $sorted = $post->comments->sortByDesc('created_at');
    return Inertia::render('SinglePost', [
        'post' => $post,
        'comments' => $sorted->values()->all(),
        'currentUser' => $currentUser, 
    ]);
}

    public function edit($id)
    {
        $post = Post::findOrFail($id);
    
        if ($post->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        return inertia('EditPosts', [
            'post' => $post,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($request->all());

        return response()->json(['success' => 'Post updated successfully.']);
    }


    public function destroy($id)
    {
        $referer = request()->headers->get('referer');

        if ($referer && strpos($referer, '/posts/'.$id) !== false) {
            return response()->json(['error' => 'Cannot delete post from this route.'], 403);
        }
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id() && Auth::user()->role != "admin") {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return response()->json(['success' => 'Post deleted successfully.']);
    }
}
