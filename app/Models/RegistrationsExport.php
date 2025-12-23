<?php

namespace App\Models;

use Carbon\Carbon;
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
            'doc_date',
            'time', 
            'place_of_birth', 
            'education', 
            'occupation', 
            'name_of_org',
            'height', 
            'weight', 
            'complexion', 
            'gotra_self', 
            'gotra_mama', 
            'caste',
            'subCaste', 
            'category',
            'marriage', 
            'fatherName',
            'father_mobile', 
            'father_occupation', 
            'father_income', 
            'mothername', 
            'mother_mobile', 
            'mother_occupation', 
            'mother_income', 
            'residence', 
            'permanent_address', 
            'sibling', 
            'married_brother', 
            'unmarried_brother', 
            'married_sister',
            'unmarried_sister', 
            'contact', 
            'email', 
            'mobile', 
            'citizenship',
            'state', 
            'dosh', // Added field for 'dosh'
            'annual_income',
            'social_group',
            'profile_picture', 
            'payment_picture', 
            'payment_type', 
            'total_payment', 
            'is_courier', 
            'payment_mode'
        )->get()
        ->map(function ($registration) {
            // Format doc_date
            if ($registration->doc_date) {
                $registration->doc_date = Carbon::parse($registration->doc_date)->format('d-m-Y');
            }
            
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
    'ID',                           // id
    'प्रत्यशी का नाम',              // name
    'जन्म तिथि',                   // doc_date
    'समय',                         // time
    'जन्म स्थान',                  // place_of_birth
    'शिक्षा',                      // education
    'व्यवसाय',                     // occupation
    'सस्थान का नाम',               // name_of_org
    'ऊंचाई',                       // height
    'वज़न',                        // weight
    'वर्ण',                        // complexion
    'गोत्र स्व',                   // gotra_self
    'गोत्र मामा',                  // gotra_mama
    'जाति',                        // caste
    'उपजाति',                     // subCaste
    'श्रेणी',                      // category
    'मांगलिक',                    // marriage
    'पिता का नाम',                // fatherName
    'पिता का मोबाइल नंबर',        // father_mobile
    'पिता का व्यवसाय',            // father_occupation
    'पिता की वार्षिक आय',         // father_income
    'माँ का नाम',                 // mothername
    'माँ का मोबाइल नंबर',         // mother_mobile
    'माँ का व्यवसाय',             // mother_occupation
    'माँ की वार्षिक आय',          // mother_income
    'निवास',                      // residence
    'स्थायी पता',                 // permanent_address
    'भाई /बहन का विवरण',          // sibling
    'विवाहित भाई',                // married_brother
    'अविवाहित भाई',               // unmarried_brother
    'विवाहित बहन',                // married_sister
    'अविवाहित बहन',               // unmarried_sister
    'सम्पर्क सूत्र',              // contact
    'ईमेल आईडी',                  // email
    'प्रत्याशी का मोबाइल नंबर',   // mobile
    'नागरिकता',                   // citizenship
    'राज्य',                      // state
    'दोष',                        // dosh
    'वार्षिक आय',                 // annual_income
    'सोशल ग्रुप',                 // social_group
    'Image',                      // profile_picture
    'Payment Picture',            // payment_picture
    'भुगतान',                     // payment_type
    'कुल भुगतान',                 // total_payment
    'कूरियर द्वारा स्मारिका',     // is_courier
    'पेमेंट मॉड',                 // payment_mode
];
    }
}
