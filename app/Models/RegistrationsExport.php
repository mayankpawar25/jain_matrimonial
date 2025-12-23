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
        'annual_income',
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
        'dosh',
        'social_group',
        'profile_picture',
        'payment_picture',
        'payment_type',
        'total_payment',
        'is_courier',
        'payment_mode'
    )->get()->map(function ($r) {
        $height = $r->height;

// Fix common wrong quote order: 5"2' → 5'2"
if ($height) {
    $height = str_replace(['"', "'"], ['INCH', 'FEET'], $height);
    $height = str_replace(['FEET', 'INCH'], ["'", '"'], $height);
}

        return [
            $r->id,
            $r->name,

            // DOB / Time / Place
            Carbon::parse($r->doc_date)->format('d-m-Y')
                . ' , ' . $r->time
                . ' , ' . $r->place_of_birth,

            $r->education,

            // Occupation / Income
            trim($r->occupation . ' , ' . $r->annual_income),

            // Height / Weight / Complexion
            trim($height . ' ,, ' . $r->weight . ' / ' . $r->complexion),

            $r->gotra_self,
            $r->gotra_mama,

            // Caste / SubCaste
            trim($r->caste . ' , ' . $r->subCaste),

            $r->category,
            $r->marriage === 'no' ? 'नहीं' : 'हाँ',

            // Father
            trim($r->fatherName . ' , ' . $r->father_mobile),
            trim($r->father_occupation . ' , ' . $r->father_income),

            // Mother
            trim($r->mothername . ' , ' . $r->mother_mobile),
            trim($r->mother_occupation . ' , ' . $r->mother_income),

            $r->residence,
            $r->permanent_address,
            $r->sibling,
            $r->married_brother,
            $r->unmarried_brother,
            $r->married_sister,
            $r->unmarried_sister,
            $r->contact,
            $r->email,
            $r->mobile,
            $r->citizenship,
            $r->state,
            $r->dosh,
            $r->social_group,
            static_asset($r->profile_picture),
            static_asset($r->payment_picture),
            $r->payment_type,
            $r->total_payment,
            $r->is_courier == 1 ? 'Yes' : 'No',
            $r->payment_mode,
        ];
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
        'ID',
        'प्रत्यशी का नाम',
        'जन्म तिथि / समय / जन्म स्थान',
        'शिक्षा',
        'व्यवसाय / वार्षिक आय',
        'ऊंचाई / वज़न / वर्ण',
        'गोत्र स्व',
        'गोत्र मामा',
        'जाति / उपजाति',
        'श्रेणी',
        'मांगलिक',
        'पिता का नाम / मोबाइल',
        'पिता का व्यवसाय / आय',
        'माँ का नाम / मोबाइल',
        'माँ का व्यवसाय / आय',
        'निवास',
        'स्थायी पता',
        'भाई /बहन का विवरण',
        'विवाहित भाई',
        'अविवाहित भाई',
        'विवाहित बहन',
        'अविवाहित बहन',
        'सम्पर्क सूत्र',
        'ईमेल आईडी',
        'प्रत्याशी का मोबाइल नंबर',
        'नागरिकता',
        'राज्य',
        'दोष',
        'सोशल ग्रुप',
        'Image',
        'Payment Picture',
        'भुगतान',
        'कुल भुगतान',
        'कूरियर द्वारा स्मारिका',
        'पेमेंट मॉड',
    ];
}

}
