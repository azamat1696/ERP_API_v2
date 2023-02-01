<?php

namespace App\Http\Controllers\Cars;

use App\Helpers\FileUploader;
use App\Http\Requests\Cars\BrandControllerRequest;
use App\Models\CarBrand;
use App\Http\Controllers\Controller;

class CarBrandController extends Controller
{

    protected $filePath;


    public function __construct()
    {
        $this->filePath = public_path('uploads/brands');

    }

    public  function index() {
        return response()->json(
           CarBrand::all()
         );
    }

    public function store(BrandControllerRequest $request) {
        $fileName = 'no-image.jpg';
        if ($request->hasFile('BrandLogo'))
        {
            $file = new FileUploader($this->filePath,$request->validated()['BrandLogo'],$request->validated()['BrandName']);
            $fileName = $file->upload();
        }
       $brand = CarBrand::create([  'BrandLogo' => $fileName, ] + $request->only('BrandName','Status'));
         return response()->json( $brand,200);
    }

    public function update(BrandControllerRequest $request,$id) {

        $brand = CarBrand::find($id);
        $fileName = $brand->BrandLogo;
        if ($request->hasFile('BrandLogo'))
        {
            if ($brand->BrandLogo != 'no-image.jpg') // delete old img
            {
                unlink($this->filePath."/".$brand->BrandLogo);
            }
             $file = new FileUploader($this->filePath,$request->validated()['BrandLogo'],$request->validated()['BrandName']);
             $fileName = $file->upload();
        }

        $brand->update([  'BrandLogo' => $fileName, ] + $request->only('BrandName','Status') );
        return response()->json($brand);
    }

    public function destroy($id) {
        $record = CarBrand::findOrFail($id);
        if ($record->BrandLogo != 'no-image.jpg') // delete old img
          {
                unlink($this->filePath."/".$record->BrandLogo);
          }
        $record->delete();

       return response()->json(true,200);
    }
}
