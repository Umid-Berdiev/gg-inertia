<?php

namespace App\Imports;

use App\Models\ChemicalComposition;
use Maatwebsite\Excel\Concerns\ToModel;

class ChemicalCompositionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ChemicalComposition([
            //
        ]);
    }
}
