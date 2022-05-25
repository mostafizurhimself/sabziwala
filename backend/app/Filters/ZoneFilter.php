<?php

namespace App\Filters;

class ZoneFilter extends Filter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $searchRelations = [];

    /**
     * Searchable columns of the table
     *
     * @var array
     */
    public $searchColumns = ['id', 'name', 'city', 'state', 'country'];


    /**
     * Filter by country
     */
    public function country($value)
    {
        $this->where('country', $value);
    }

    /**
     * Filter by city
     */
    public function city($value)
    {
        $this->where('city', $value);
    }
}