<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Events\AfterSheet;


class ForAllExports implements   FromArray, WithHeadings, WithProperties,ShouldAutoSize,WithEvents
{
    public $query;
    public $hearder;
    public function __construct($query,$hearder)
{
    $this->query = $query;
    $this->hearder = $hearder;
}

     public function array(): array
     {
         // TODO: Implement array() method.
         return DB::select($this->query);
     }

     public function headings(): array
{
    return  $this->hearder ;
}

    public function properties(): array
{
    return [
        'creator' => 'Happy Ways Car',
        'lastModifiedBy' => 'Happy Ways Car',
        'title' => 'Rezervasyon Raporu',
        'description' => 'Rezervasyon Filtireleme Raporu',
        'subject' => 'Rezervasyonlar',
        'company' => 'Happy Ways Car',
    ];
}

    public function registerEvents(): array
{
    return [
        AfterSheet::class    => function(AfterSheet $event) {
            $cellRange = 'A1:M1'; // All headers
            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
        },

    ];
}
}
