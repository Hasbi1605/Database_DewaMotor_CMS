<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Create a new category
     */
    public function createCategory(array $validatedData): Category
    {
        return Category::create($validatedData);
    }

    /**
     * Update an existing category
     */
    public function updateCategory(array $validatedData, Category $category): Category
    {
        $category->update($validatedData);
        return $category;
    }

    /**
     * Delete category
     */
    public function deleteCategory(Category $category): bool
    {
        return $category->delete();
    }

    /**
     * Get categories grouped by type
     */
    public function getCategoriesGroupedByType(): array
    {
        return [
            'class' => Category::getByType('class'),
            'brand' => Category::getByType('brand'),
            'document' => Category::getByType('document'),
            'condition' => Category::getByType('condition')
        ];
    }

    /**
     * Get available types
     */
    public function getAvailableTypes(): array
    {
        return ['class', 'brand', 'document', 'condition'];
    }
}
