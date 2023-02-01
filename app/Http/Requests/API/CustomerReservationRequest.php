<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class CustomerReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->currentDateTime = new \DateTime();
        return [
            // 'cardNumber' => 'required|digits_between:16,16|numeric', // Müşteri Kredi Kart Numarası
            // 'cardExpireMonth' => 'required|size:2,2', // Müşteri Kart Bitiş Ay,
            // 'cardExpireYear' => 'required|size:2,2', // Müşteri Kart Bitiş Ay,
            // 'cardName' => 'required|min:3', // Müşteri Kart Üzerindeki İsim Soyisim
            // 'cardSecureCode' => 'required|digits_between:3,3|numeric', // Müşteri Kart Güvenlik Kodu

            'dropLocationId' => 'required', // Aracın Bırakılacagı Lokation ID
            'pickupLocationId' => 'required',// Aracın Teslim Alacagı Lokation ID
            'carId' => 'required|exists:cars,id', // Araç ID
            'reservationStartDateTime' => 'required|date_format:Y-m-d H:i|after:'.$this->currentDateTime->format('Y-m-d H:i'), // reservation Başlama tarihi saatı
            'reservationEndDateTime' => 'required|date_format:Y-m-d H:i|after_or_equal:'.Carbon::create($this->reservationStartDateTime)->addDays(3), // reservation bitiş tarih saatı

            'transferCarDifferentLocationCost' => 'nullable', // araç farklı lokayson transfer ücreti
            'dailyRentCost' => 'required|numeric', // günlük 150 tl
            'totalDaysRentCost' => 'required|numeric', // örn 3 => 3 x 150 => 450 tl
            'extraServicesTotalCost' => 'nullable', // extra ürünlerin toplamı
            'totalCost' => 'required|numeric', // toplam ücret
            'totalRentDay' => 'required',  // 3 gün => 3
            'extraServicesProducts' => 'nullable', // extra seçilen ürünler Array
            'flyNo' => 'nullable', // uçuş NO
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' => [
                'errors' => $validator->errors()
            ],
        ];

        throw new HttpResponseException(response()->json($response, 400));

    }
}
