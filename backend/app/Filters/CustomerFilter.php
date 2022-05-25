<?php

namespace App\Filters;

class CustomerFilter extends Filter
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
    public $searchColumns = ['id', 'first_name', 'last_name', 'phone', 'email'];

    /**
     * Filter by status
     */
    public function status($value)
    {
        $this->where('status', $value);
    }
}
