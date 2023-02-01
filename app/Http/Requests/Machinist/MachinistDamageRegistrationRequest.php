<?php

namespace App\Http\Requests\Machinist;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MachinistDamageRegistrationRequest extends FormRequest
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
            'id' => ['sometimes', 'exists:machinist_damage_registrations,id'],
            'user_id' => ['sometimes','exists:users,id'],
            'car_damage_ids' => ['sometimes'],
            'cars_id' => ['sometimes','exists:cars,id'],
            'machinist_id' => ['sometimes','exists:machinists,id'],
            'ReservationStartDate' => ['sometimes'],
            'ReservationEndDate' => ['sometimes'],
            'Description' => ['sometimes'],
            'EstimatedRepairCost' => ['sometimes'],
            'ReservationStatus' => ['sometimes'],
            'isReserved' => ['sometimes'],
        ];
    }

    public function getValidatorInstance(): Validator
    {
        $this->payload();
        return parent::getValidatorInstance(); // TODO: Change the autogenerated stub
    }

    protected function payload()
    {
        $this->merge([
            //'Status' => $this->request->get('Status') ? 1 : 0,
            'Status' => $this->request->get('Status') === 'true' ? 1 : 0,
//            'isReserved' => $this->request->get('isReserved') === 'true' ? 1 : 0,
        ]);

    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 400));

    }
}