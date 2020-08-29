<?php

namespace App\Exports;

use App\Model\Customer;
use DB;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportExcelCustomer implements FromArray, WithHeadings, WithEvents
{
    protected $customers;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(array $customers)
    {
        $this->customers = $customers;
        // 
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
                $event->sheet->setCellValue('A1', 'Laporan Data Pelanggan');
                $event->sheet->mergeCells('A1:I2');
                $event->sheet->setCellValue('A3', '');

                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('H')->setAutoSize(true);
                $event->sheet->getColumnDimension('I')->setAutoSize(true);
            },

            AfterSheet::class => function(AfterSheet $event) use ($styleHeading, $styleGenereal) {
                $event->sheet->getStyle('A4:I4')->applyFromArray($styleHeading);
                $event->sheet->getStyle('A1:I500')->applyFromArray($styleGenereal);
            },
        ];
    }

    public function array(): array
    {
        return $this->customers;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pelanggan',
            'Telepon',
            'Pekerjaan',
            'Metode Pembayaran',
            'Tipe Kredit',
            'Unit',
            'Status Berkas',
            'Sales'
        ];
    }
}
