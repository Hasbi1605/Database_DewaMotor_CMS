<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Get all categories with caching
     */
    public function all(): Collection
    {
        return Cache::remember('categories_all', 3600, function () {
            return $this->model->all();
        });
    }

    /**
     * Get categories by type with caching
     */
    public function getByType(string $type): Collection
    {
        return Cache::remember("categories_type_{$type}", 3600, function () use ($type) {
            return $this->model->where('type', $type)->get();
        });
    }

    /**
     * Get categories grouped by type with caching
     */
    public function getAllGroupedByType(): Collection
    {
        return Cache::remember('categories_grouped_by_type', 3600, function () {
            return $this->model->all()->groupBy('type');
        });
    }

    /**
     * Clear category cache
     */
    public function clearCache(): void
    {
        $types = ['class', 'brand', 'document', 'condition'];

        Cache::forget('categories_all');
        Cache::forget('categories_grouped_by_type');

        foreach ($types as $type) {
            Cache::forget("categories_type_{$type}");
        }
    }
}
