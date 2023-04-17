<?php

namespace App\Exports;

use App\Models\User as ModelsUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ModelsUser::all();
    }

    public function headings():array{
        return ['ID','Name','Email','Created_at','Updated_at'];
    }
}
