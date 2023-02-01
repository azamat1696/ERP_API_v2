<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class SearchCarRequest extends FormRequest
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
            'pickupLocationID' => 'required|exists:offices,id',
            'rentedDays' => 'required|numeric|min:3|not_in:0|integer',
            'reservationStartDateTime' => 'required|date_format:Y-m-d H:i|after:'.$this->currentDateTime->format('Y-m-d H:i'), // reservation Başlama tarihi saatı
            'reservationEndDateTime' => 'required|date_format:Y-m-d H:i|after_or_equal:'.Carbon::create($this->reservationStartDateTime)->addDays(3), // reservation bitiş tarih saatı
            'type' => ['sometimes'],
            'transmission' => ['sometimes'],
            'fuel' => ['sometimes']
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
