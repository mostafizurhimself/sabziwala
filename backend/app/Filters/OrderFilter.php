<?php

namespace App\Filters;

class OrderFilter extends Filter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $searchRelations = [
        'rider' => ['first_name', 'last_name'],
        'zone' => ['name'],
    ];

    /**
     * Searchable columns of the table
     *
     * @var array
     */
    public $searchColumns = ['id'];

    /**
     * Filter by status
     */
    public function status($value)
    {
        $this->where('status', $value);
    }

    /**
     * Filter by ridera
     */
    public function riders($ids)
    {
        $ids = explode(',', $ids);
        $this->whereIn('rider_id', $ids);
    }

    /**
     * Filter by rider
     */
    public function rider($value)
    {
        $this->where('rider_id', $value);
    }

    /**
     * Filter by customer
     */
    public function customer($value)
    {
        $this->where('customer_id', $value);
    }

    /**
     * Filter by zone
     */
    public function zone($value)
    {
        $this->where('zone_id', $value);
    }

    /**
     * Filter by from date
     */
    public function from($value)
    {
        $this->whereDate('created_at', '>=', $value);
    }

    /**
     * Filter by to date
     */
    public function to($value)
    {
        $this->whereDate('created_at', '<=', $value);
    }
}