<?php

namespace App\Http\Requests\Cars;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarPricesRequest extends FormRequest
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
          $commonRules = [
            'DailyPrice' => ['required'],
            'WeeklyPrice' => ['required'],
            'MonthlyPrice' => ['required'],
            'YearlyPrice' =>  ['required'],
            'WeeklyPriceRange' => ['sometimes'],
            'MonthlyPriceRange' => ['sometimes'],
            'YearlyPriceRange' => ['sometimes'],
            'id' => ['sometimes','exists:car_prices,id'],
//            'model_id' => ['required','exists:car_models,id','unique:car_prices,model_id']
        ];
 
          $uniqueRules = !empty($this->id) ? ['model_id' => ['required','exists:car_models,id' ]] : ['model_id' => ['required','exists:car_models,id','unique:car_prices,model_id']];

        return array_merge($commonRules,$uniqueRules);
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
