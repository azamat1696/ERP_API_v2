<?php

namespace App\Exports\Export;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Events\AfterSheet;

class CarDamagesExport implements FromCollection, WithHeadings, WithProperties,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
        return DB::table('machinist_export_v')->get();
    }
    
    public function headings(): array
    {
         
        return [
            'PLAKA',
            'MARKA-MODEL',
            'MAKİNİST TÜRÜ',
            'MAKİNİST FİRMA',
            'HASAR BAŞLIĞI',
            'HASAR KODU & SEVİYESİ',
            'HASAR TUTARI',
            'KULLANILAN MALZEMELER',
            'HASAR DURUMU',
            'MÜŞTERİ',
            'ŞİRKETİ',
            'ŞİRKET GURUBU',
            'HASAR OLUŞTURMA TARİHİ',
            'REZERVASYON OLUŞTURMA TARİHİ',
            'REZERVASYON BİTİŞ TARİHİ',
            'HASAR AÇIKLAMA'
        ];
    }
    public function properties(): array
    {
     return [ 
         'creator'        => 'Happy Ways Car',
         'lastModifiedBy' => 'Happy Ways Car',
         'title'          => 'Makinisit Hasar Reservasyon Raporu',
         'description'    => 'Güncel Makinisit Hasar Reservasyon Raporu',
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
