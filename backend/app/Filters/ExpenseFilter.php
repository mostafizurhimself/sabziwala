<?php

namespace App\Filters;

class ExpenseFilter extends Filter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $searchRelations = [
        'expenseType' => ['name']
    ];

    /**
     * Searchable columns of the table
     *
     * @var array
     */
    public $searchColumns = ['id', 'amount'];

         /**
     * expenseTypes filter
     */
    public function expenseTypes($ids)
    {
        $ids = explode(',', $ids);
        return $this->whereIn('expense_type_id', $ids);
    }

}
