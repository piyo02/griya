<?php

namespace App\Exports;

use DB;
use App\Model\Transaction;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportExcelCashIn implements FromArray, WithHeadings, WithEvents
{
    protected $cashIn;
    
    public function __construct(array $cashIn)
    {
        $this->cashIn = $cashIn;
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        $styleHeading = [
            'font' => [
                'bold' => true,
            ],
        ];

        $styleGenereal = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
        $styleCurr = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        return [
            // Handle by a closure.
            BeforeSheet::class => function(BeforeSheet $event) {
                $event->sheet->setCellValue('A1', 'Laporan Kas Masuk');
                $event->sheet->mergeCells('A1:E2');
                $event->sheet->setCellValue('A3', '');

                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
            },

            AfterSheet::class => function(AfterSheet $event) use ($styleHeading, $styleGenereal, $styleCurr) {
                $event->sheet->getStyle('A4:E4')->applyFromArray($styleHeading);
                $event->sheet->getStyle('A1')->applyFromArray($styleGenereal);
                $event->sheet->getStyle('D5:D500')->applyFromArray($styleCurr);
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->cashIn;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Sumber Pemasukan',
            'Rekening Tujuan',
            'Jumlah',
            'Keterangan'
        ];
    }

}
