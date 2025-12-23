<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBalanceSheet implements FromArray
{
    protected $balance;

    public function __construct(array $balance)
    {
        $this->balance= $balance;
    }

    public function array(): array
    {
        return $this->balance;
    }

  
}