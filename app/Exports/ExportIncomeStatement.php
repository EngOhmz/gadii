<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class  ExportIncomeStatement implements FromArray
{
    protected $statement;

    public function __construct(array $statement)
    {
        $this->statement= $statement;
    }

    public function array(): array
    {
        return $this->statement;
    }

  
}