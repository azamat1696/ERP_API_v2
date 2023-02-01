<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Helpers\FileUploader;
use App\Http\Requests\Users\CustomerDriversRequest;
use App\Models\CustomerDocument;
use App\Models\CustomerDrivers;

class CustomerDriversController extends Controller
{
    protected $filePath;


    public function __construct()
    {
        
        $this->filePath = public_path('uploads/user-documents');

    }
    
    public function store(CustomerDriversRequest $request) {
        $fileName = 'no-image.jpg';
        if ($request->hasFile('File'))
        {
            $file = new FileUploader($this->filePath,$request->validated()['File'],random_int(1111,9999999));
            $fileName = $file->upload();
        }
        $driver = CustomerDrivers::create(
            $request->only(
                'customer_id',
                'DriverName',
                'DriverSurname',
                'DriverPhone',
                'DriverEmail',
                'Status',
            )
        );
        CustomerDocument::create([
               'customer_drivers_id' => $driver->id,
               'DocumentTypeId' => $request->validated()['DocumentTypeId'],
               'DocumentPath' => $fileName,
               'DocumentDateOfExpire' => $request->validated()['DocumentDateOfExpire'],
               'DocumentDateOfIssue' => $request->validated()['DocumentDateOfIssue'],
               'DocumentNumber' => $request->validated()['DocumentNumber'],
           ]
        );
         $record = CustomerDrivers::with('document')->find($driver->id);
        return response()->json($record);
    }
}
