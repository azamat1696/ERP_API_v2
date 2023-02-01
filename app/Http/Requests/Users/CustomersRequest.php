<?php

namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class CustomersRequest extends FormRequest
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
        $commonRules =  [
            // 'districts_id' => ['required','exists:districts,id'],
            // 'cities_id' => ['required','exists:cities,id'],
            // 'districts_id' => ['sometimes','exists:districts,id'],
            // 'cities_id' => ['sometimes','exists:cities,id'],
            // 'customer_groups_id' => ['sometimes','exists:customer_groups,id'],
            'CustomerType' => ['required'],
            'Name' => ['required'],
            'Surname' => ['required'],
            'Gender' => ['sometimes'],
            'CompanyName' => ['sometimes'],
            //    'CompanyName' => ['sometimes','unique:customers,CompanyName'],
//            'Phone' => ['sometimes','min:11','unique:customers,Phone'],
            'Password' => ['sometimes'],
            'DateOfBirthDate' => ['sometimes'],
            'Address' => ['sometimes'],
            'Status' => ['sometimes']
        ];


        //   $uniqueRules = $this->id ? 
        //       [
        //           'Email' => ['sometimes'],
        //           'Phone' => ['sometimes']
        //       ] : 
        //       [
        //           'Email' => ['sometimes','email','unique:customers,Email'],
        //           'Phone' => ['sometimes','min:11','unique:customers,Phone'],
        //       ];
        $uniqueRules = $this->id ?
            [
                // 'Email' => ['sometimes'],
                'Phone' => ['sometimes']
            ] :
            [
                // 'Email' => ['sometimes','email'],
                'Phone' => ['sometimes'],
            ];

        return array_merge($commonRules,$uniqueRules);
    }
    public function getValidatorInstance(): Validator
    {
        $this->payload();
        return parent::getValidatorInstance(); // TODO: Change the autogenerated stub
    }

    protected function payload() {
        $this->merge([
            'Status'  => $this->request->get('Status') == 'true' ? 1 : 0,
            'Phone'  => $this->request->get('Phone')  ?  $this->request->get('Phone') : '',
            'Password' => ($this->request->has('Password')) ? Hash::make($this->request->get('Password')):null,
            'DateOfBirthDate' => ($this->request->get('DateOfBirthDate') !== null) ? date('Y-m-d',strtotime($this->request->get('DateOfBirthDate'))):null
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
