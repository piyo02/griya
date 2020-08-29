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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class exportExcelCashFlow implements FromArray, WithHeadings, WithEvents
{
    protected $accounts;
    protected $cashFlow;

    public function __construct(array $accounts, array $cashFlow)
    {
        $this->accounts = $accounts;
        $this->cashFlow = $cashFlow;
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
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];

        $styleGeneral = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];

        $styleListAccount = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ]
        ];
        $styleListSaldo = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $number = 4;
        $number_ = 5 + count($this->accounts);
        return [
            // Handle by a closure.
            BeforeSheet::class => function(BeforeSheet $event) use($number) {
                $event->sheet->setCellValue('A1', 'Laporan Keuangan');
                $event->sheet->mergeCells('A1:G2');
                $event->sheet->setCellValue('A3', '');

                //accounts
                foreach ($this->accounts as $key => $account) {
                    $event->sheet->setCellValue('B'.$number, $account->name);
                    $event->sheet->setCellValue('C'.$number, number_format($account->saldo));
                    $number++;
                }

                $event->sheet->setCellValue('A'.$number++, '');

                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
            },

            AfterSheet::class => function(AfterSheet $event) use ($styleHeading, $styleGeneral, $styleListAccount, $styleListSaldo, $number_) {
                $event->sheet->getStyle('A1:A1000')->applyFromArray($styleListAccount);
                $event->sheet->getStyle('A1')->applyFromArray($styleGeneral);
                $event->sheet->getStyle('A' . $number_ .':G'. $number_)->applyFromArray($styleHeading);
                $event->sheet->getStyle('B4:B'.($number_-1))->applyFromArray($styleListAccount);
                $event->sheet->getStyle('C4:C'.($number_-1))->applyFromArray($styleListSaldo);
                $event->sheet->getStyle('F'.($number_+1).':F1000')->applyFromArray($styleListSaldo);
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->cashFlow;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Tanggal',
            'Rekening Sumber',
            'Rekening Tujuan',
            'Tipe',
            'Jumlah',
            'Keterangan'
        ];
    }
}
