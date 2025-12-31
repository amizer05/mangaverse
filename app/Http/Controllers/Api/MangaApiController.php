<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MangaApiService;
use App\Models\Manga;
use Illuminate\Http\Request;

class MangaApiController extends Controller
{
    /**
     * Search manga from external API.
     */
    public function search(Request $request, MangaApiService $apiService)
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ]);

        $results = $apiService->searchManga(
            $request->q,
            $request->get('limit', 10)
        );

        return response()->json([
            'data' => $results,
            'count' => count($results),
        ]);
    }

    /**
     * Get manga details from external API.
     */
    public function getDetails(Request $request, MangaApiService $apiService)
    {
        $request->validate([
            'mal_id' => ['required', 'integer'],
        ]);

        $manga = $apiService->getMangaById($request->mal_id);

        if (!$manga) {
            return response()->json([
                'message' => 'Manga not found',
            ], 404);
        }

        return response()->json([
            'data' => $manga,
        ]);
    }

    /**
     * Get top manga from external API.
     */
    public function getTop(Request $request, MangaApiService $apiService)
    {
        $request->validate([
            'limit' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'type' => ['sometimes', 'string', 'in:manga,novels,oneshots,manhwa,manhua'],
        ]);

        $results = $apiService->getTopManga(
            $request->get('limit', 20),
            $request->get('type', 'manga')
        );

        return response()->json([
            'data' => $results,
            'count' => count($results),
        ]);
    }

    /**
     * Sync manga from API to database.
     */
    public function sync(Request $request, MangaApiService $apiService)
    {
        $request->validate([
            'title' => ['sometimes', 'string'],
            'mal_id' => ['sometimes', 'integer'],
        ]);

        if ($request->has('mal_id')) {
            $apiData = $apiService->getMangaById($request->mal_id);
            if (!$apiData) {
                return response()->json(['message' => 'Manga not found'], 404);
            }
            $manga = $apiService->syncMangaFromApi($apiData);
        } elseif ($request->has('title')) {
            $manga = $apiService->findAndSyncManga($request->title);
            if (!$manga) {
                return response()->json(['message' => 'Manga not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Please provide title or mal_id'], 422);
        }

        return response()->json([
            'message' => 'Manga synced successfully',
            'data' => new \App\Http\Resources\MangaResource($manga),
        ], 201);
    }

    /**
     * Get manga statistics.
     */
    public function getStats(Request $request, MangaApiService $apiService)
    {
        $request->validate([
            'mal_id' => ['required', 'integer'],
        ]);

        $stats = $apiService->getMangaStats($request->mal_id);

        if (!$stats) {
            return response()->json(['message' => 'Statistics not found'], 404);
        }

        return response()->json([
            'data' => $stats,
        ]);
    }
}
