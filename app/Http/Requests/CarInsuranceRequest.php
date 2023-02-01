<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarInsuranceRequest extends FormRequest
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
        return [
            'cars_id' => ['required'],
            'StartDateTime' => ['required'],
            'EndDateTime' => ['required'],
            'InsurancePrice' => ['sometimes'],
            'Note' => ['sometimes'],
            'Status' => ['sometimes'],
            'InvoiceFile' => ['sometimes'],
            'Type' => ['sometimes']
        ];
    }
    public function getValidatorInstance(): Validator
    {
        $this->payload();
        return parent::getValidatorInstance(); // TODO: Change the autogenerated stub
    }

    protected function payload() {
        $this->merge([
//            'Status'  => $this->request->get('Status') == 'true' ? 1 : 0,
            'StartDateTime' => date('Y-m-d',strtotime($this->request->get('StartDateTime'))),
            'EndDateTime' => date('Y-m-d',strtotime($this->request->get('EndDateTime')))
        ]);

    }
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request1',
            'payload' =>  $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 400));

    }
}
