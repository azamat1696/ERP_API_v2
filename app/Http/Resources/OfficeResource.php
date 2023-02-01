<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'OfficeAddress' => $this->OfficeAddress,
            'OfficeContacts' => $this->OfficeContacts,
            'OfficeName' => $this->OfficeName,
            'OfficePhone' => substr($this->OfficePhone,4),
            'OfficeEmail' => $this->OfficeEmail,
            'Positions' => $this->Positions,
            'OfficeWorkingPeriods' => $this->OfficeWorkingPeriods,
            'cities_id' => $this->cities_id,
            'districts_id' => $this->districts_id,
            'Status' => $this->Status 
        ];
        //return parent::toArray($request);
    }
}
