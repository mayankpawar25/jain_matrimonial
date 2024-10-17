<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Registration;


class RegistrationsExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Registration::select(
            'id',
            'name', 
            'email', 
            'mobile', 
            'marriage', 
            'doc_date', 
            'time', 
            'citizenship',
            'place_of_birth', 
            'state', 
            'gotra_self', 
            'gotra_mama', 
            'caste',
            'subCaste', 
            'weight', 
            'height', 
            'complexion', 
            'category',
            'residence', 
            'dosh', // Added field for 'dosh'
            'education', 
            'occupation', 
            'fatherName',
            'father_mobile', 
            'father_occupation', 
            'father_income', 
            'mothername', 
            'mother_mobile', 
            'mother_occupation', 
            'mother_income', 
            'permanent_address', 
            'sibling', 
            'married_brother', 
            'unmarried_brother', 
            'married_sister',
            'unmarried_sister', 
            'contact', 
            'social_group',
            'profile_picture', 
            'payment_picture', 
            'payment_type', 
            'total_payment', 
            'is_courier', 
            'payment_mode'
        )->get()
        ->map(function ($registration) {
            // Generate full URL for profile picture using static_asset
            $registration->profile_picture = static_asset($registration->profile_picture);
            $registration->payment_picture = static_asset($registration->payment_picture);
            return $registration;
        });
    }

    // Customizing the styles of the heading row
    public function styles(Worksheet $sheet)
    {
        return [
            // Apply style to the first row (heading)
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => '000000']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFFF']],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                // Freeze the top row
                $event->sheet->getDelegate()->freezePane('A2');

                // Auto-size columns
                foreach (range('A', $event->sheet->getHighestColumn()) as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name', 
            'Email', 
            'Mobile', 
            'Marriage', 
            'Date', 
            'Time', 
            'Citizenship',
            'Place of Birth', 
            'State', 
            'Gotra Self', 
            'Gotra Mama', 
            'Caste',
            'SubCaste', 
            'Weight', 
            'Height', 
            'Complexion', 
            'Category',
            'Residence', 
            'Dosh',
            'Education', 
            'Occupation', 
            'Father`s Name',
            'Father`s Mobile',
            'Father`s Occupation',
            'Father`s Income',
            'Mother`s Name', 
            'Mother`s Mobile',
            'Mother`s Occupation',
            'Mother`s Income',
            'Permanent Address',
            'Sibling', 
            'Married Brother', 
            'Unmarried Brother', 
            'Married Sister',
            'Unmarried Sister', 
            'Contact', 
            'Social Group',
            'Profile Picture', 
            'Payment Picture', 
            'Payment Type', 
            'Total Payment', 
            'Is Courier', 
            'Payment Mode',
        ];
    }
}
