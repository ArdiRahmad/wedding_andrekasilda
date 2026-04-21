<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * Berikan contoh data 1 baris agar user paham formatnya
    */
    public function collection()
    {
        return collect([
            [
                'Nama' => 'Bpk. Budi & Kel',
                'Whatsapp' => '628123456789',
                'Kategori' => 'Keluarga',
                'Sisi (groom/bride)' => 'groom',
                'Pax' => '2',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'name',
            'whatsapp_number',
            'category',
            'side',
            'pax',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Tebalkan header
            1    => ['font' => ['bold' => true]],
        ];
    }
}