<?php
namespace App\Payments;

class CardPlusClass {
    
    // https://www.happywayscar.com/order-completed
    // https://www.happywayscar.com/order-uncompleted
    
    // http://test.happywayscar.com/pay-transaction/fail
    // http://test.happywayscar.com/pay-transaction/success
    private $clientId = "120000175"; // Üye iş yeri numarası
    private $storeType = "3d_pay"; // Üye iş yerinin ödeme modeli
    private $processType ="Auth"; // İşlem Tipi
    private $amount = ""; // Çekilecek tutar
    private $currency = "949"; // ISO para birimi kodu (TL için 949 )
    public $oid = ""; // Sipariş Numarası
    private $okUrl =   "http://apirentacar.neareasttechnology.net/pay-transaction/success"; // ödeme başarılı ise yönlendirelecek sayfa
    private $failUrl = "http://apirentacar.neareasttechnology.net/pay-transaction/fail"; // ödeme başarısız ise yönlendirelecek sayfa
    private $lang = "tr"; // Nestpay ödeme sayfasında kullanılan dil
    private $hash = ""; // hashlanmış deger
    private $taksit = ""; // taksit işlemleri için
    private $rnd = "";
    private $storekey = "HP75CR17"; // işletmeye verilen storekey
    private $payload =  [];
    protected $cardParams = [];
    protected $companyParams = [];
    protected $payParams = [];
    private $formUrl = "https://sanalpos.card-plus.net/fim/est3Dgate";
    public $staticParams = [];

    public function __construct($amount, $cardParams,$companyParams=[])
    {
        $this->rnd = microtime();
        $this->oid = $this->generateOid();


        $this->amount = $amount;
        $this->cardParams = $cardParams;
        $this->companyParams = $companyParams;
        //$this->payParams = $payParams;
        $this->hash = $this->generateOrderHash();
        $this->init();

    }

    public function init()
    {

      $this->staticParams = [
          "url" => $this->formUrl,
          "params" => $this->initPayParams() + $this->initCardParams() +$this->initCompanyParams()
      ];
    }

    public function initPayParams(): array {
        return [
            "clientid" => $this->clientId,
            "amount" => $this->amount, // miktar
            "oid" => $this->oid,  // order id sipariş numarası
            "okUrl" => $this->okUrl, // başarılı link
            "failUrl" => $this->failUrl, // başarısız link
            "rnd" => $this->rnd, // microtime
            "hash" => $this->hash,
            "islemtipi" => $this->processType,
            "taksit" => $this->taksit, // bydefaoult null
            "storetype" => $this->storeType,
            "lang" => $this->lang,
            "currency" => $this->currency
        ];
    }

    public function initCardParams(): array
    {
        return [
            "pan" => $this->cardParams['pan'],
            "cv2" => $this->cardParams['cv2'],
            "Ecom_Payment_Card_ExpDate_Month" => $this->cardParams['Ecom_Payment_Card_ExpDate_Month'],
            "Ecom_Payment_Card_ExpDate_Year" => $this->cardParams['Ecom_Payment_Card_ExpDate_Year']
        ];
    }

    public function initCompanyParams(): array {
        return  [
            'Email' => $this->companyParams['email'],
            'firmaAdı' => env('CP_COMPANY_NAME'),
            'tismi' => $this->companyParams['name']." ".$this->companyParams['surname']
        ];
    }

    public  function generateOid(): string {
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
        return $today . $rand;
    }

    public  function generateOrderHash() :string {

        $hashset = $this->clientId
            . $this->oid
            . $this->amount
            . $this->okUrl
            . $this->failUrl
            . $this->processType
            . $this->taksit
            . $this->rnd
            . $this->storekey;
        return base64_encode(pack('H*',sha1($hashset)));
    }
}
