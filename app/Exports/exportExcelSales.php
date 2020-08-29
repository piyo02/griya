<?php

namespace App\Exports;

use App\Model\Sale;
use DB;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportExcelSales implements FromQuery, WithMapping, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
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
                $event->sheet->setCellValue('A1', 'Laporan Fee Marketing');
                $event->sheet->mergeCells('A1:D2');
                $event->sheet->setCellValue('A3', '');

                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
            },

            AfterSheet::class => function(AfterSheet $event) use ($styleHeading, $styleGenereal) {
                $event->sheet->getStyle('A4:D4')->applyFromArray($styleHeading);
                $event->sheet->getStyle('A1:D500')->applyFromArray($styleGenereal);
            },
        ];
    }

    public function query()
    {
        // return Customer::select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as cluster'))
        //             ->join('clusters', 'clusters.id', '=', 'customers.cluster_id')
        //             ->join('sales', 'sales.id', '=', 'customers.sale_id')
        //             ->orderBy('sales.id')
        //             ->where('state_id' ,'!=', 3);
        
        return Sale::select('customers.*', 'sales.name as sales_name', DB::raw('CONCAT(clusters.block, "", clusters.number) as cluster'))
                    ->leftJoin(DB::raw('(
                        customers 
                        JOIN states ON states.id = customers.state_id
                        JOIN clusters ON clusters.id = customers.cluster_id
                    )'), 'customers.sale_id', '=', 'sales.id')
                    ->where('state_id' ,'!=', 3)
                    ->orWhere('state_id' ,'=', null)
                    ->orderBy('customers.date');
    }

    public function map($fee): array
    {
        return [
            $fee->sales_name,
            $fee->cluster,
            $fee->name,
            $fee->fee,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Sales',
            'Unit',
            'Pelanggan',
            'Fee',
        ];
    }
}
