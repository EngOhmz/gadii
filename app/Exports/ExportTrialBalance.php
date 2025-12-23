<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class  ExportTrialBalance implements FromArray
{
    protected $trial;

    public function __construct(array $trial)
    {
        $this->trial= $trial;
    }

    public function array(): array
    {
        return $this->trial;
    }

  
}