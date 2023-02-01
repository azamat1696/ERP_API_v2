<?php
namespace App\Services;
use App\Models\Extra;

class ReservationServices {
    
    public function __construct()
    {
    }

    public function extraService($data){

        $extraServices = Extra::all();

        $extras = [];

        foreach ($data as  $item){
            $t = json_decode(json_encode($item));


            if($t->totalPrice > 0){
                foreach ($extraServices as $ext)
                {
                    if ($t->id == $ext->id)
                    {
                        $ext->Price = $t->totalPrice;
                        $extras[] = $ext;
                    }

                }

            }
        }
        return  $extras;
    }
}
