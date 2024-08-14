<?php

namespace App\Exports;

use App\Models\Gig;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GigsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Gig::all(['id', 'name', 'brand_name', 'about', 'amount_per_user', 'employee_id', 'status']);    }

        public function map($gig):array
        {
            return[
                $gig->id,
                $gig->name,
                $gig->brand_name,
                $gig->about,
                $gig->amount_per_user,
                $gig->employee_id,
                $gig->status,

            ];
        }

        public function headings(): array
        {
            return [
                'ID',
                'Name',
                'Brand Name',
                'About',
                'Amount Per User',
                'Employee ID',
                'Status'
            ];
        }

    
}
