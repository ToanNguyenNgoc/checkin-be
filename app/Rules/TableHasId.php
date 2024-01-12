<?php

namespace App\Rules;

use App\Helpers\Helper;
use App\Models\BaseModel;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TableHasId implements Rule
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where('id', $value);

        if (Helper::tableHasColumn($this->table, 'status')) {
            $query = $query->where('status', '!=', BaseModel::STATUS_DELETED);
        }

        return $query->exists();
    }

    public function message()
    {
        return 'The selected :attribute does not exist.';
    }
}

