<?php

namespace App\Exports\Export;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Events\AfterSheet;

class CarsExport implements FromCollection, WithHeadings, WithProperties,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('cars_v')->select('BrandName','ModelName','Year','LicencePlate','ClassName','CarTransmissionName','FuelTypeName','EngineCapacity','OfficeName')->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },

        ];
    }

    public function headings(): array
    {
        return [
            'Marka',
            'Model',
            'Üretim senesi',
            'Plakası',
            'Sınıf',
            'Vites Tipi',
            'Yakıt Tipi',
            'Motor Hacmi',
            'Ofis',
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Happy Ways Car',
            'lastModifiedBy' => 'Happy Ways Car',
            'title'          => 'Araçlar Raporu',
            'description'    => 'Güncel Araçlar Raporu',
            'subject'        => 'Araçlar',
            'company'        => 'Happy Ways Car',
        ];
    }
}
