<?php

namespace App\Filters;

class SalaryFilter extends Filter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $searchRelations = [
        'employee'=> ['first_name', 'last_name']
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
     * Filter by status
     */
    public function month($value)
    {
        $this->where('month', $value);
    }

         /**
     * Employees filter
     */
    public function employees($ids)
    {
        $ids = explode(',', $ids);
        return $this->whereIn('employee_id', $ids);
    }

                /**
     * Filter by zone
     */
    public function zone($value)
    {
        $this->where('zone_id', $value);
    }

}
