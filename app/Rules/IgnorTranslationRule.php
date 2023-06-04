<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class IgnorTranslationRule implements Rule
{
    protected $table;
    protected $column;
    protected $parentId;
    protected $parentTable;

    public function __construct($table,$parentTable, $column, $parentId)
    {
        $this->table = $table;
        $this->column = $column;
        $this->parentId = $parentId;
        $this->parentTable = $parentTable;
    }

    public function passes($attribute, $value)
    {
        $count = DB::table($this->table)
            ->where($this->column, $value)
            ->where($this->parentTable, '!=',$this->parentId)
            ->count();

        return $count === 0;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
