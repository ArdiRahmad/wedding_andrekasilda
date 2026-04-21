<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuestsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Guest::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Whatsapp Number',
            'Category',
            'RSVP Status',
            'Pax',
            'Message',
            'Is Wishes',
            'WA Sent',
            'Unique Code',
            'Side',
            'Created At',
            'Link'
        ];
    }

    public function map($guest): array
    {
        return [
            $guest->id,
            $guest->name,
            $guest->whatsapp_number,
            $guest->category,
            $guest->rsvp_status,
            $guest->pax,
            $guest->message,
            $guest->is_wishes ? 'Yes' : 'No',
            $guest->is_wa_sent ? 'Yes' : 'No',
            $guest->unique_code,
            $guest->side,
            $guest->created_at->format('Y-m-d H:i:s'),
            'https://yourdomain.com/guest/' . $guest->code
        ];
    }
}