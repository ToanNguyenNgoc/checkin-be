<?php

namespace App\Rules;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\Rule;

class TableHasColumn implements Rule
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function passes($attribute, $value)
    {
        return Helper::tableHasColumn($this->table, $value);
    }

    public function message()
    {
        return 'The selected :attribute value does not exist in table.';
    }
}

