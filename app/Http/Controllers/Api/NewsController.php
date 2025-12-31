<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index(Request $request)
    {
        $query = News::whereNotNull('published_at')
            ->where('published_at', '<=', now());

        $news = $query->withCount('comments')
            ->latest('published_at')
            ->paginate($request->get('per_page', 15));

        return NewsResource::collection($news);
    }

    /**
     * Display the specified news.
     */
    public function show(News $news)
    {
        $news->load(['comments.user']);

        return new NewsResource($news);
    }

    /**
     * Store a comment on news.
     */
    public function storeComment(Request $request, News $news)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment = NewsComment::create([
            'news_id' => $news->id,
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        $comment->load('user');

        return response()->json([
            'message' => 'Comment posted successfully',
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'username' => $comment->user->username,
                ],
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }

    /**
     * Delete a comment.
     */
    public function deleteComment(Request $request, NewsComment $comment)
    {
        if ($comment->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}






