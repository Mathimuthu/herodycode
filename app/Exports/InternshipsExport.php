<?php

namespace App\Exports;

use App\Models\Internship;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InternshipsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Internship::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Status',
            'Description',
            'Category',
            'Start Date',
            'End Date',
            'Duration',
            'Stipend',
            'Benifits',
            'Place',
            'Count',
            'Skills',
            'Proofs',
            'Employe_ID',
            'Created_at',
        ];
    }
}
