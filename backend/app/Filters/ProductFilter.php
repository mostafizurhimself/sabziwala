<?php

namespace App\Filters;

class ProductFilter extends Filter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $searchRelations = [
        'category' => ['name'],
        'zone'     => ['name']
    ];

    /**
     * Searchable columns of the table
     *
     * @var array
     */
    public $searchColumns = ['id', 'code', 'name'];


    /**
     * Category filter
     */
    public function categories($ids)
    {
        $ids = explode(',', $ids);
        return $this->whereIn('category_id', $ids);
    }

    /**
     * Filter by zone
     */
    public function zone($value)
    {
        $this->where('zone_id', $value);
    }

    /**
     * Tags filter
     */
    public function tags($ids)
    {
        $ids = explode(',', $ids);
        return $this->whereHas('tags', function ($tag) use ($ids) {
            return $tag->whereIn('id', $ids);
        });
    }

    /**
     * Filter by status
     */
    public function status($value)
    {
        $this->where('status', $value);
    }

    /**
     * Filter by status
     */
    public function featured($value)
    {
        $this->where('is_featured', $value);
    }
}