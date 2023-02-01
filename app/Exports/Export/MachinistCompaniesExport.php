<?php

namespace App\Exports\Export;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Events\AfterSheet;

class MachinistCompaniesExport implements FromCollection, WithHeadings, WithProperties,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('machinists')->select('CompanyName','CompanyPhone','CompanyEmail','AuthorizedPerson','CompanyTaxAddress','CompanyTaxNumber','CompanyAddress','Status' )->get();
    }
    public function headings(): array
    {

        return [
            'MAKİNİST İSMİ',
            'TELEFON',
            'E-POSTA',
            'YETKİLİ KİŞİ',
            'VERGİ DAİRESİ',
            'VERGİ NUMARASI',
            'BÖLGESİ',
            'STATÜSÜ'
        ];
    }
    public function properties(): array
    {
        return [
            'creator'        => 'Happy Ways Car',
            'lastModifiedBy' => 'Happy Ways Car',
            'title'          => 'Makinisit ŞİRKET Raporu',
            'description'    => 'Güncel MAKİNİST FİRMASI Raporu',
            'subject'        => 'Araç Hasarları',
            'company'        => 'Happy Ways Car',
        ];
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

}
