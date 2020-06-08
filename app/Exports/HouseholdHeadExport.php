<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class HouseholdHeadExport implements FromCollection
{
    protected $heads;
    function __construct($heads) {
        $this->heads = $heads;
      }
    public function collection()
    {
        return new Collection($this->heads);
    }
}