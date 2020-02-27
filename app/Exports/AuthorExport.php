<?php

namespace App\Exports;

use App\Author;
use Maatwebsite\Excel\Concerns\FromCollection;

class AuthorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Author::all();
    }
}
