<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ActivateAccountRequest;
use App\Http\Requests\API\CreateAccountRequest;
use App\Http\Requests\API\LoginAccountRequest;
use App\Mail\ConfirmAccount;
use App\Mail\GetNewPassword;
use App\Models\Customer;
use App\Models\CustomerDocument;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactModel;


class AuthController extends Controller
{
    public function register(Request $request) {

        /*
         * ########### STEPS ##################
         * 1. Create Customer
         * 2. Create Customer Document
         * 3. Send Mail Activation Link
         */
        $checkCustomer = Customer::where('email',$request->input('email'))->where('isDeleted',true)->first();

        if($checkCustomer){
            $validatorCustomer = Validator::make($request->all(),[
                "password" => "required|min:4|confirmed|required_with:password_confirmation",
                "password_confirmation" => "required|min:4",
            ]);

            if (!$validatorCustomer->fails())
            {
                // herhangi bir validate error yoktur
                $checkCustomer->update([
                    'isDeleted' => false,
                    'Password' => Hash::make($validatorCustomer->validated()['password']),
                    'EmailVerifiedHash' => random_int(100000, 999999)
                ]);

                try {
                    Mail::to($checkCustomer->Email)->send(new ConfirmAccount($checkCustomer));
                    return response()->json([
                        'status' => true,
                        'status_code' => 200,
                        'message' => 'Registration Successfully Send Confirm Code To Mail',
                        'payload' =>  [
                            "sentMail" => true,
                        ],
                    ]);
                } catch (\Exception $e)  {
                    return response()->json(
                        [ 'status' => true,
                            'status_code' => 202,
                            'message' => 'Registration Successfully But Can not send Mail',
                            'payload' =>  [
                                "sentMail" => false,
                                "auth_token" => $checkCustomer->createToken('auth_token')->plainTextToken
                            ],
                        ],400);
                }
            } else {
                $response = [
                    'status' => false,
                    'status_code' => 400,
                    'message' => 'Bad Request',
                    'errors' => $validatorCustomer->errors(),
                ];

                throw new HttpResponseException(response()->json($response, 400));
            }


        }





        $validator = Validator::make($request->all(),[
            "name" => "required|min:3|max:100",
            "surname" => "required|min:3|max:100",
            "email" => "required|email|unique:customers",
            "phone" => "required|min:10|max:12|unique:customers",
            "password" => "required|min:4|confirmed|required_with:password_confirmation",
            "password_confirmation" => "required|min:4",
            "gender" => "required",
            "driving_license_no" =>"required|min:6|unique:customer_documents,DocumentNumber",
            "passport_no" => "required|min:6|unique:customer_documents,DocumentNumber",
            "address" => "required|min:10",
            // "email_verified_hash" => "required"
        ]);
        if($validator->fails()){
            $response = [
                'status' => false,
                'status_code' => 400,
                'message' => 'Bad Request',
                'errors' => $validator->messages(),
            ];

            throw new HttpResponseException(response()->json($response, 400));
        }
        $newCustomer = Customer::create([
            'CustomerType' => 'Individual',
            'Name' => $validator->validated()['name'],
            'Surname'=> $validator->validated()['surname'],
            'Gender'=> $validator->validated()['gender'],
            'Email'=> $validator->validated()['email'],
            'Phone'=> $validator->validated()['phone'],
            'Password' => Hash::make($validator->validated()['password']),
            'Address' => $validator->validated()['address'],
            'Status' => false,
            'EmailVerifiedHash' => random_int(100000, 999999)
        ]);

        if ($request->has('driving_license_no'))  {
            CustomerDocument::create([
                'customer_id' => $newCustomer->id,
                'DocumentDateOfExpire',
                'DocumentDateOfIssue',
                'DocumentTypeId' => 1, // sabit ehliyet türü id si
//                'DocumentPath',
                'DocumentNumber' => $validator->validated()['driving_license_no'],
                'DocumentNotes' => 'İnternet üzerinde kayıt',
                'Status' => 1,
            ]);
        }

        if ($request->has('passport_no')) {
            CustomerDocument::create([
                'customer_id' => $newCustomer->id,
                'DocumentDateOfExpire',
                'DocumentDateOfIssue',
                'DocumentTypeId' => 2, // sabit ehliyet türü id si
//                'DocumentPath',
                'DocumentNumber' => $validator->validated()['passport_no'],
                'DocumentNotes' => 'İnternet üzerinde kayıt',
                'Status' => 1,
            ]);
        }

        try {
            Mail::to($newCustomer->Email)->send(new ConfirmAccount($newCustomer));
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Registration Successfully Send Confirm Code To Mail',
                'payload' =>  [
                    "sentMail" => true,
                ],
            ]);
        } catch (\Exception $e)  {
            return response()->json(
                [ 'status' => true,
                    'status_code' => 202,
                    'message' => 'Registration Successfully But Can not send Mail',
                    'payload' =>  [
                        "sentMail" => false,
                        "auth_token" => $newCustomer->createToken('auth_token')->plainTextToken
                    ],
                ],400);
        }


    }

    public function activateAccount(ActivateAccountRequest $request)
    {

        $customer = Customer::where('Email','=',$request->validated()['email'])
            ->where('EmailVerifiedHash','=',$request->validated()['confirmNumber'])
            ->where('Status',false)
            ->firstOrFail();
        $customer->update([
            'Status' => true,
            'EmailVerifiedHash'  => ''
        ]);
        return response()->json( [
            'status' => true,
            'status_code' => 200,
            'message' => 'Your Member Registration Has Been Approved Successfully. ',
        ],200);
    }

    public function login(LoginAccountRequest $request) {
        //isDeleted => 0 deleted, => 1 not deleted
        $customerLogin = Customer::where('Email','=',$request->validated()['email'])->where('isDeleted',false)->first();

        if(!$customerLogin){
            return response()->json(
                [ 'status' => true,
                    'status_code' => 401,
                    'message' => 'Your account is unsubscribed please register again',
                ]
                ,401);
        }


        if (Hash::check($request->validated()['password'],$customerLogin->Password))
        {
            return response()->json(
                [ 'status' => true,
                    'status_code' => 201,
                    'message' => 'Login Successfully',
                    'payload' => [
                        "auth_token" => $customerLogin->createToken('auth_token')->plainTextToken ]
                ]
                ,201);
        }

        return response()->json([
            'status' => false,
            'status_code' => 401,
            'message' => 'User Not Found',
        ],401);

    }
    public function checkUser() {

        return response()->json(auth()->user());
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Logout Successfully',

        ],200);
    }

    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'oldPassword' => 'required',
            'password' => 'min:6|required|same:password_confirmation',
            'password_confirmation' => 'min:6|required'
        ]);

        if (!$validator->fails())
        {
            $customer = Customer::find(auth()->user()->id);

            if (Hash::check($validator->validated()['oldPassword'],$customer->Password))
            {
                $customer->update([
                    'Password' => Hash::make($validator->validated()['password'])
                ]);
                auth()->user()->tokens()->delete();
                return response()->json([
                    'message' => 'successfully',
                    'status' => 201,
                    'payload' =>  [
                        'success' => 'Password Updated',

                    ]
                ], 201);
            }
            $response = [
                'status' => 'failure',
                'status_code' => 400,
                'message' => 'Bad Request',
                'payload' =>  [
                    'password' => ['Old Password Are Incorrect ']
                ],
            ];
            throw new HttpResponseException(response()->json($response, 400));
        }

        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'payload' =>  $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }

    public function dashboard() {

        $customer = Customer::findOrFail(auth()->user()->id);

        $drivingLicenceNo = CustomerDocument::where('customer_id',auth()->user()->id)->where('DocumentTypeId','=',1)->first();
        $passportNo = CustomerDocument::where('customer_id',auth()->user()->id)->where('DocumentTypeId','=',2)->first();

        $response = [
            'status' => 'failure',
            'status_code' => 200,
            'message' => 'Bad Request',
            'payload' => [
                'userDetail' => [
                    'name' => $customer->Name,
                    'surname' => $customer->Surname,
                    'email' => $customer->Email,
                    'phone' => $customer->Phone,
                    'gender' => $customer->Gender,
                    'address' => $customer->Address,
                    'driving_license_no' =>$drivingLicenceNo ? $drivingLicenceNo->DocumentNumber : '',
                    'passport_no' => $passportNo ? $passportNo->DocumentNumber : '' ,
                ],
                'reservations' => $this->userReservations()
            ],
        ];
        return response()->json($response,200);
    }
    public function userReservations() {
        $oldReservationsQuery = "select
       reservations.id,
       reservations.ReservationNo as orderNo,
       reservations.TransactionNo,
       reservations. RentDays as rent_day,
       old_reservations.PickupLocation as LTitle,
       old_reservations.DropLocation as Dtitle,
       old_reservations.StartDateTime as start_time,
       old_reservations.EndDateTime as end_time,
       old_reservations.ReservationStatus,
       old_reservations.LicencePlate as license_plate,
       old_reservations.BrandName as car_brand_title,
       old_reservations.ModelName as car_model_title,
       old_reservations.TotalPrice as total,
       old_reservations.CurrencySymbol
       from reservations
       inner join old_reservations ON reservations.id = old_reservations.id 
       WHERE reservations.customers_id =".auth()->user()->id;

        $oldReservations =  DB::select($oldReservationsQuery);


        $currentReservationsQuery = "select
       reservations.id,
       reservations.ReservationNo as orderNo,
       reservations.TransactionNo,
       reservations. RentDays as rent_day,
       current_reservations_v.PickupLocation as LTitle,
       current_reservations_v.DropLocation as Dtitle,
       current_reservations_v.StartDateTime as start_time,
       current_reservations_v.EndDateTime as end_time,
       current_reservations_v.ReservationStatus,
       current_reservations_v.LicencePlate as license_plate,
       current_reservations_v.BrandName as car_brand_title,
       current_reservations_v.ModelName as car_model_title,
       current_reservations_v.TotalPrice as total,
       current_reservations_v.CurrencySymbol
        from reservations
        inner join current_reservations_v ON reservations.ReservationNo = current_reservations_v.ReservationNo
        WHERE reservations.customers_id =".auth()->user()->id;

        $currentReservations = DB::select($currentReservationsQuery);
        return array_merge($currentReservations,$oldReservations);
    }
    public function unsubscribe(Request $request) {
        $user = Customer::findOrFail(auth()->user()->id);
        $user->update(['isDeleted' => true,'Status' =>false]);
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'The Acount Unsubscribed Successfully',

        ],200);
    }
    public function getNewPassword(Request $request){
        $validator = Validator::make($request->all(),['email' => 'required|email']);
        if ($validator->fails()){
            return response()->json([
                'status' => true,
                'status_code' => 401,
                'message' => $validator->errors(),
            ],401);
        }
        $customerDetails = Customer::where('Email',$validator->validated()['email'])->where('isDeleted',false)->first();
        $newPassword = random_int(100000, 999999);
        if (!$customerDetails){
            return response()->json([
                'status' => true,
                'status_code' => 401,
                'message' =>  "User not found. Please register",
            ],401); 
        }
        $customerDetails->update(['Password' => Hash::make($newPassword)]);
        if (!$customerDetails){
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Başarısız',
                'payload' =>  [
                    "sentMail" => true,
                ],
            ],400);
        }
        try {
            Mail::to($customerDetails->Email)->send(new GetNewPassword($customerDetails,$newPassword));
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'New Password Successfully Send  To Your Mail',
                'payload' =>  [
                    "sentMail" => true,
                ],
            ],200);
        } catch (\Exception $e)  {
            return response()->json(
                [ 'status' => true,
                    'status_code' => 202,
                    'message' => 'Check your email and try agian please',
                    'payload' =>  [
                        "Error" => $e->getMessage(),
                    ],
                    
                ],400);
        }
       
    }

    public function contactForm(Request $request){
        $validator = Validator::make($request->all(),[
            'NameSurname' => 'required',
            'Email' => 'required|email' ,
            'Description' => 'required'
        ]);
        if($validator->fails()){
            $response = [
                'status' => false,
                'status_code' => 400,
                'message' => 'Bad Request',
                'errors' => $validator->messages(),
            ];

            throw new HttpResponseException(response()->json($response, 400));
        }
        ContactModel::create([
            'NameSurname' => $request->NameSurname,
            'Email' => $request->Email,
            'Description' => $request->Description
        ]);
        return response()->json([
            'status' => true,
            'status_code' => 201,
            'message' => 'Contact form succcessfully created'
        ],201);
    }


}
