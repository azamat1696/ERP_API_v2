<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests\Users\CustomersRequest;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        
//        ray()->showQueries();
        return response()->json(
            Customer::detail()->get()
//            Customer::detail()->get()
        );
    }
    public function searchCustomer(Request $request) {

        $text = $request->input_value;

        if(filter_var($text, FILTER_VALIDATE_EMAIL)) {

            $result = Customer::detail()->where('email', $text)
                ->orWhere('name', 'like', '%' . $text . '%')->get();
        }
        else {
            $result = Customer::detail()
                ->where('Name', $text)
                ->orWhere('Name', 'like', '%' . $text . '%')
                ->orWhere('Surname', 'like', '%' . $text . '%')
                ->get();

        }

        return response()->json($result);

    }
    
    public function store(CustomersRequest  $request) {
        
         $customer = Customer::create($request->validated());
         return response()->json(
             Customer::with('customerDocuments')->with('customerDrivers')->where('id',$customer->id)->first()
         );
    }
    public function update(CustomersRequest  $request,$id) {
        $item = Customer::findOrFail($id);
        $item->update($request->validated());
        $customer = Customer::detail()->find($item->id);
        return response()->json($customer,200);
    }
}
