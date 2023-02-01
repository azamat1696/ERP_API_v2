<?php

namespace App\Exports\Export;

 
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReservationsExport implements FromCollection, WithStyles,WithHeadings, WithProperties,ShouldAutoSize,WithEvents
{

    public function headings(): array
    {
        return  $this->excelHeading();
    }
    public function styles(Worksheet $sheet)
    {
     
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): \Illuminate\Support\Collection
    {
        return DB::table('reservations_reports')->get();
    }
    
    public function excelHeading(): array
    {
        return [
             
            'PLAKA', // => ok
            'FATURA NO',// => ok
            'TAHSİLAT NO',// => ok
            'SÖZLEŞME NO',// => ok
            'KİRA CİNSİ',// => ok
            'KULLANAN ŞİRKET',// => ok
            'KULLANAN BİRİM',// => ok
            'ÇIKIŞ LOKASYON',// => ok
            'GİRİŞ LOKSAYON',// => ok
            'ZİMMET SAHİBİ',// => ok
            'REZERVASYON DURUMU',
            'ARAÇ',// => ok araç tüm bilgileri
            
            'TOPLAM KİRA GÜNÜ',// => ok
          
            'BAŞLAMA TARİHİ',// => ok
            'BİTME TARİHİ',// => ok
            
            'UYGULANAN KİRA BEDELİ',// => ok sembol eklenecek
            'PARA BİRİMİ',// => ok
            
            'DÖVİZ KURU',// => ok
            
            'GÜNLÜK KİRA BEDELİ',// => ok sembol
            'TOPLAM KİRA BEDELİ',// => ok  sembol
            
            'EKSTA ÜRÜN BEDELİ',// => ok   sembol
            
            'TOPLAM REZERVASYON BEDELİ',// => ok sembol
            'TOPLAM ALINAN BEDEL ',// => ok  sembol
            'ÖDEME YÖNTEMİ',// => ok  türkçe
            'ÖDEME DURUMU',// => ok türkç
        ];
    }
    
    public function properties(): array
    {
        return [
            'creator'        => 'Happy Ways Car',
            'lastModifiedBy' => 'Happy Ways Car',
            'title'          => 'Rezervasyonlar Raporu',
            'description'    => 'Güncel Araçların Rezervasyon Raporu',
            'subject'        => 'Reservations',
            'company'        => 'Happy Ways Car',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

}
