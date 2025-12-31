<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, News $news)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        NewsComment::create([
            'news_id' => $news->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('news.public.show', $news)->with('success', 'Comment posted successfully');
    }

    /**
     * Remove the specified comment.
     * Users can only delete their own comments, admins can delete any
     */
    public function destroy(NewsComment $comment)
    {
        // Check if user owns the comment or is admin
        $user = auth()->user();
        if ($comment->user_id != $user->id && !$user->isAdmin()) {
            abort(403, 'Not authorized');
        }

        $news = $comment->news;
        $comment->delete();

        return redirect()->route('news.public.show', $news)->with('success', 'Comment deleted');
    }
}
