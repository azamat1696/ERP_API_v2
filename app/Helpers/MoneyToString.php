<?php

namespace App\Helpers;
class MoneyToString {

    protected $integer;
    protected $seperator;
    protected $currencySembol;
    protected $currencyType;
  
    public $formattedMoneyString;
    public function __construct($integer, $separator, $currencySembol, $currencyType)
    {
        $this->integer = $integer;
        $this->seperator = $separator;
        $this->currencySembol = $currencySembol;
        $this->currencyType = $currencyType;
        $this->formattedMoneyString = $this->init();
    }

    protected function init() :string {
        $sayarr = explode($this->seperator,$this->integer);
        $sentTitle = ($this->currencySembol != '₺') ? 'SENT' : 'KRŞ';
        $str = "";
        $items = array(
            array("", ""),
            array("BİR", "ON"),
            array("İKİ", "YİRMİ"),
            array("ÜÇ", "OTUZ"),
            array("DÖRT", "KIRK"),
            array("BEŞ", "ELLİ"),
            array("ALTI", "ALTMIŞ"),
            array("YEDİ", "YETMİŞ"),
            array("SEKİZ", "SEKSEN"),
            array("DOKUZ", "DOKSAN")
        );

        for ($eleman = 0; $eleman<count($sayarr); $eleman++) {

            for ($basamak = 1; $basamak <=strlen($sayarr[$eleman]); $basamak++) {
                $basamakd = 1 + (strlen($sayarr[$eleman]) - $basamak);


                try {
                    switch ($basamakd) {
                        case 6:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " YÜZ";
                            break;
                        case 5:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][1];
                            break;
                        case 4:
                            if ($items[substr($sayarr[$eleman],$basamak - 1,1)][0] != "BİR") $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " BİN";
                            else $str = $str . " BİN";
                            break;
                        case 3:
                            if($items[substr($sayarr[$eleman],$basamak - 1,1)][0]=="") {
                                $str.=" ";
                            }
                            elseif ($items[substr($sayarr[$eleman],$basamak - 1,1)][0] != "BİR" ) $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " YÜZ";

                            else $str = $str . " YÜZ";
                            break;
                        case 2:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][1];
                            break;
                        default:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0];
                            break;
                    }
                } catch (Exception $err) {
                    echo $err->getMessage();
                    break;
                }
            }
            if ($eleman< 1) $str = $str . " ".$this->currencyType ." (".$this->currencySembol.")";
            else {
                if ($sayarr[1] != "00") $str = $str . "  ".$sentTitle;
            }
        }
        return $str;
    }
}
