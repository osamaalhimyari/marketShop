<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CategoryFilter extends ApiFilter {
    protected $safeParms = [
        'catId' => ['eq'],
       
    ];

    protected $columnMap = [
        'catId' => 'id',
       
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!='
    ];
}