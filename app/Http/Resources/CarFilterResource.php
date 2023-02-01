<?php

namespace App\Http\Resources;

use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\CarPrices;
use Illuminate\Http\Resources\Json\JsonResource;

class CarFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
//        $carBrand =  CarBrand::find($this->car_brands_id);
//        $carModel =  CarModel::find($this->car_models_id);
//        $carPrices = CarPrices::where('model_id','=',$this->car_models_id)->first();
        return [
            'id' => $this->id,
            'car' => $this->BrandName." ".$this->ModelName,
            'img' => $this->Image,
            'licensePlate' => $this->LicencePlate,
            'color' => $this->CarColor,
            'damages' => 1,
            'prices' => 180,
        ];
    }
}
