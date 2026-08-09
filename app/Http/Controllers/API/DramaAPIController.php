<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DramaAPIController extends Controller
{
    // Timeout configuration
    protected $timeout = 15; 
    protected $retryCount = 2;
    
    public function fetchDramas(Request $request)
    {
        try {
            $query = $request->input('q', 'korean drama');
            $year = $request->input('year', '2026');
            
            // Create cache key
            $cacheKey = "dramas_{$query}_{$year}";
            
            // Try to get from cache first
            $dramas = Cache::remember($cacheKey, 3600, function () use ($query, $year) {
                return $this->fetchDramasFromApi($query, $year);
            });
            
            if ($dramas === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch data from TVmaze API'
                ], 503);
            }

            return response()->json([
                'success' => true,
                'data' => $dramas,
                'total' => count($dramas),
                'cached' => Cache::has($cacheKey)
            ]);

        } catch (\Exception $e) {
            \Log::error('Drama API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function fetchDramasFromApi($query, $year)
    {
        try {
            // Add timeout and retry logic
            $response = Http::timeout($this->timeout)
                ->retry($this->retryCount, 1000)
                ->get('https://api.tvmaze.com/search/shows', [
                    'q' => $query
                ]);

            if ($response->failed()) {
                return null;
            }

            $data = $response->json();
            
            // Filter and transform data
            $dramas = $this->transformDramaData($data, $year);
            
            return $dramas;
            
        } catch (\Exception $e) {
            \Log::error('TVmaze API Error: ' . $e->getMessage());
            return null;
        }
    }

    private function transformDramaData($data, $year)
    {
        $dramas = [];
        $showIds = [];

        // First pass: collect IDs and filter
        foreach ($data as $item) {
            $show = $item['show'] ?? [];
            
            // Skip if not Korean
            if (!isset($show['language']) || strtolower($show['language']) !== 'korean') {
                continue;
            }
            
            // Skip if year doesn't match
            if ($year && isset($show['premiered'])) {
                $showYear = date('Y', strtotime($show['premiered']));
                if ($showYear != $year) {
                    continue;
                }
            }
            
            $showIds[] = $show['id'] ?? null;
        }

        // Batch fetch additional data
        $batchData = $this->batchFetchAdditionalData($showIds);

        // Second pass: build final data
        foreach ($data as $item) {
            $show = $item['show'] ?? [];
            
            // Apply same filters
            if (!isset($show['language']) || strtolower($show['language']) !== 'korean') {
                continue;
            }
            
            if ($year && isset($show['premiered'])) {
                $showYear = date('Y', strtotime($show['premiered']));
                if ($showYear != $year) {
                    continue;
                }
            }
            
            $showId = $show['id'] ?? null;
            
            $dramas[] = [
                'id' => $showId,
                'title' => $show['name'] ?? 'Unknown Title',
                'genres' => $show['genres'] ?? [],
                'premiered' => $show['premiered'] ?? null,
                'year' => isset($show['premiered']) ? date('Y', strtotime($show['premiered'])) : null,
                'rating' => $show['rating']['average'] ?? null,
                'poster' => $show['image']['medium'] ?? null,
                'poster_large' => $show['image']['original'] ?? null,
                'summary' => strip_tags($show['summary'] ?? 'No synopsis available'),
                'language' => $show['language'] ?? null,
                'status' => $show['status'] ?? null,
                'runtime' => $show['runtime'] ?? null,
                'network' => $show['network']['name'] ?? null,
                'official_site' => $show['officialSite'] ?? null,
                'score' => $item['score'] ?? null,
                'cast' => $batchData[$showId]['cast'] ?? [],
                'episodes' => $batchData[$showId]['episodes'] ?? 0,
            ];
        }

        // Sort by rating
        usort($dramas, function ($a, $b) {
            return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
        });

        return $dramas;
    }

    private function batchFetchAdditionalData($showIds)
    {
        $result = [];
        
        // Limit to first 20 shows to prevent too many requests
        $showIds = array_slice(array_filter($showIds), 0, 20);
        
        foreach ($showIds as $id) {
            $result[$id] = [
                'cast' => $this->fetchCast($id),
                'episodes' => $this->fetchEpisodeCount($id)
            ];
            
            // Small delay to prevent rate limiting
            usleep(100000); // 100ms
        }
        
        return $result;
    }

    private function fetchCast($showId)
    {
        if (!$showId) {
            return [];
        }

        $cacheKey = "cast_{$showId}";
        
        return Cache::remember($cacheKey, 86400, function () use ($showId) {
            try {
                $response = Http::timeout(5)
                    ->get("https://api.tvmaze.com/shows/{$showId}/cast");

                if ($response->failed()) {
                    return [];
                }

                $castData = $response->json();
                $cast = [];

                foreach (array_slice($castData, 0, 5) as $actor) {
                    $cast[] = [
                        'name' => $actor['person']['name'] ?? 'Unknown',
                        'character' => $actor['character']['name'] ?? 'Unknown',
                        'image' => $actor['person']['image']['medium'] ?? null,
                    ];
                }

                return $cast;

            } catch (\Exception $e) {
                \Log::error("Cast fetch error for show {$showId}: " . $e->getMessage());
                return [];
            }
        });
    }

    private function fetchEpisodeCount($showId)
    {
        if (!$showId) {
            return 0;
        }

        $cacheKey = "episodes_{$showId}";
        
        return Cache::remember($cacheKey, 86400, function () use ($showId) {
            try {
                $response = Http::timeout(5)
                    ->get("https://api.tvmaze.com/shows/{$showId}/episodes");

                if ($response->failed()) {
                    return 0;
                }

                return count($response->json());

            } catch (\Exception $e) {
                \Log::error("Episode count error for show {$showId}: " . $e->getMessage());
                return 0;
            }
        });
    }

    public function getDramaDetail($id)
    {
        try {
            $cacheKey = "drama_detail_{$id}";
            
            $drama = Cache::remember($cacheKey, 86400, function () use ($id) {
                return $this->fetchDramaDetail($id);
            });

            if ($drama === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Drama not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $drama,
                'cached' => Cache::has($cacheKey)
            ]);

        } catch (\Exception $e) {
            \Log::error('Drama detail error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function fetchDramaDetail($id)
    {
        try {
            $response = Http::timeout(10)
                ->retry(2, 1000)
                ->get("https://api.tvmaze.com/shows/{$id}");

            if ($response->failed()) {
                return null;
            }

            $show = $response->json();

            return [
                'id' => $show['id'] ?? null,
                'title' => $show['name'] ?? 'Unknown Title',
                'genres' => $show['genres'] ?? [],
                'premiered' => $show['premiered'] ?? null,
                'year' => isset($show['premiered']) ? date('Y', strtotime($show['premiered'])) : null,
                'rating' => $show['rating']['average'] ?? null,
                'poster' => $show['image']['medium'] ?? null,
                'poster_large' => $show['image']['original'] ?? null,
                'summary' => strip_tags($show['summary'] ?? 'No synopsis available'),
                'language' => $show['language'] ?? null,
                'status' => $show['status'] ?? null,
                'runtime' => $show['runtime'] ?? null,
                'network' => $show['network']['name'] ?? null,
                'official_site' => $show['officialSite'] ?? null,
                'cast' => $this->fetchCast($id),
                'episodes' => $this->fetchEpisodeCount($id),
            ];

        } catch (\Exception $e) {
            \Log::error("Drama detail fetch error for ID {$id}: " . $e->getMessage());
            return null;
        }
    }
}