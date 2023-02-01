<?php

namespace App\Http\Requests\Cars;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarFuelTypesRequest extends FormRequest
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
            'FuelTypeName' => ['required','min:3','unique:car_fuel_types,FuelTypeName'],
            'Status' => ['required'],
            'id' => ['sometimes','exists:car_fuel_types']
        ];
    }

    public function getValidatorInstance(): Validator
    {
        $this->payload();
        return parent::getValidatorInstance(); // TODO: Change the autogenerated stub
    }

    protected function payload() {
        $this->merge([
            'Status'  => $this->request->get('Status') == 'true' ? 1 : 0,
        ]);

    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' =>  $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 400));

    }
}
