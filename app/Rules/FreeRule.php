<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class FreeRule implements Rule
{
    protected $request;
    private $fieldFrom;
    private $fieldTo;
    private $from;
    private $to;
    private $table;

    public function __construct($from, $to, $fieldFrom, $fieldTo, $table)
    {
        $this->from = $from;
        $this->to = $to;
        $this->fieldFrom = $fieldFrom;
        $this->fieldTo = $fieldTo;
        $this->table = $table;
    }

    public function passes($attribute, $value)
    {
        if (!$this->from || !$this->to || !$this->fieldFrom || !$this->fieldTo || !$this->table) {
            return false;
        }

        if (strtotime($this->from) === false || strtotime($this->to) === false) {
            return false;
        }

        $result = DB::table($this->table)
            ->where($attribute, $value)
            ->where(
                function ($query) {
                    $query->where(
                        function ($query) {
                            $query->where($this->fieldFrom, '<=', $this->from)
                                ->where($this->fieldTo, '>=', $this->from);
                        }
                    )->orWhere(
                        function ($query) {
                            $query->where($this->fieldFrom, '>=', $this->from)
                                ->where($this->fieldTo, '>=', $this->to);
                        }
                    )->orWhere(function ($query) {
                        $query->where($this->fieldFrom, '>=', $this->from)
                            ->where($this->fieldTo, '<=', $this->to);
                    });
                }
            )
            ->count();

        return $result === 0;
    }

    public function message()
    {
        return "The :attribute should be free in specified period";
    }
}
