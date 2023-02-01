<?php

namespace App\Exports;

 use Maatwebsite\Excel\Concerns\ShouldAutoSize;
 use Maatwebsite\Excel\Concerns\WithHeadings;
 use Maatwebsite\Excel\Concerns\WithProperties;
 use Maatwebsite\Excel\Concerns\FromArray;
     class ReservationReportsExport implements   FromArray, WithHeadings, WithProperties, ShouldAutoSize
{
    public $rows;
    public $headings;
    public function __construct($rows, $headings)
    {
        $this->rows = $rows;
        $this->headings = $headings;
    }
 
    public function array(): array
     {
      // TODO: Implement array() method.

        return $this->rows;
      }

     public function headings(): array
    {
        return $this->headings;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Happy Ways Car',
            'lastModifiedBy' => 'Happy Ways Car',
            'title'          => 'Rezervasyon Raporu',
            'description'    => 'Rezervasyon Filtireleme Raporu',
            'subject'        => 'Rezervasyonlar',
            'company'        => 'Happy Ways Car',
        ];
    }
}
