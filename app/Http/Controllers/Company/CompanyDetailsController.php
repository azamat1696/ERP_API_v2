<?php

namespace App\Http\Controllers\Company;
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\CompanyDetailRequest;
use App\Models\CompanyDetails;


class CompanyDetailsController extends Controller
{
    protected $filePath;


    public function __construct()
    {
        $this->filePath = public_path('uploads/base');

    }
    public function index() {
        return response()->json(CompanyDetails::firstOrFail());
    }
    public function update(CompanyDetailRequest $request) {

        $fileName = 'no-image.jpg';

        if ($request->hasFile('CompanyLogo'))
        {
            $file = new FileUploader($this->filePath,$request->validated()['CompanyLogo'],$request->validated()['CompanyName']);
            $fileName = $file->upload();
        }

       $detail = CompanyDetails::first();
        if (!empty($detail) )
        {
             if ($fileName != 'no-image.jpg' && $detail->CompanyLogo != 'no-image.jpg' )
             {
                 unlink($this->filePath."/".$detail->CompanyLogo);
             }

             $detail->update( ['CompanyLogo' => ( $fileName != 'no-image.jpg' && $detail->CompanyLogo  ) ? $fileName  : $detail->CompanyLogo  ] + $request->validated());

        } else {

            $detail = CompanyDetails::create( ['CompanyLogo' => $fileName,'CompanyID' => 123] + $request->validated() );
        }

        // Insert
        //$save->update(['CompanyLogo' => $fileName] + $request->validated());
        return response()->json($detail);
    }
}
