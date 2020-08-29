<?php

namespace App\Exports;

use DB;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;

class exportExcelCluster implements FromArray, WithHeadings, WithEvents
{
    protected $clusters;
    
    public function __construct(array $clusters)
    {
        $this->clusters = $clusters;
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

        return [
            // Handle by a closure.
            BeforeSheet::class => function(BeforeSheet $event) {
                $event->sheet->setCellValue('A1', 'Laporan Blok Cluster');
                $event->sheet->mergeCells('A1:C2');
                $event->sheet->setCellValue('A3', '');

                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
            },

            AfterSheet::class => function(AfterSheet $event) use ($styleHeading, $styleGenereal) {
                $event->sheet->getStyle('A4:C4')->applyFromArray($styleHeading);
                $event->sheet->getStyle('A1:C500')->applyFromArray($styleGenereal);
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->clusters;
    }

    public function headings(): array
    {
        return [
            'Unit',
            'Status',
            'Pelanggan'
        ];
    }
}
