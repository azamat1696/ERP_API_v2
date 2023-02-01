<?php

namespace App\Http\Controllers\Users;

 
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CustomerDocumentsRequest;
use App\Models\CustomerDocument;
use Illuminate\Support\Facades\DB;

class CustomerDocumentController extends Controller
{

    protected $filePath;


    public function __construct()
    {
        $this->filePath = public_path('uploads/user-documents');

    }

    /**
     * @throws \Exception
     */
    public function store(CustomerDocumentsRequest $request) {
        $fileName = 'no-image.jpg';
        if ($request->hasFile('File'))
        {
            $file = new FileUploader($this->filePath,$request->validated()['File'],random_int(1111,9999999));
            $fileName = $file->upload();
        }
        
        if ($request->has('DocumentTypeId') && $request->only('DocumentTypeId') !== 1){
            CustomerDocument::where('customer_id',$request->only('customer_id'))->where('DocumentTypeId',1)->update(['Status'=> 0]);
        }
        if ($request->has('DocumentTypeId') && $request->only('DocumentTypeId') !== 2){
            CustomerDocument::where('customer_id',$request->only('customer_id'))->where('DocumentTypeId',2)->update(['Status'=> 0]);
        }
        if ($request->has('DocumentTypeId') && $request->only('DocumentTypeId') !== 3){
            CustomerDocument::where('customer_id',$request->only('customer_id'))->where('DocumentTypeId',3)->update(['Status'=> 0]);
        }
            
        $document = CustomerDocument::create(
            $request->only(
                'customer_id',
                     'DocumentDateOfExpire',
                     'DocumentDateOfIssue',
                     'DocumentTypeId',
                     'DocumentNumber',
                     'DocumentNotes',
                     'Status') + 
                     ['DocumentPath' => $fileName]
        );
      
        return response($document);
    }
    // this fn for tablet create document
    public function createDocument(CustomerDocumentsRequest $request) {
        
        $fileName = 'no-image.jpg';
        $fileName2 = 'no-image.jpg';
        if ($request->has('File'))
        {
            $fileName = time()."-front.png";
            $img = substr($request->File,strpos($request->File,',')+1);
            $file = base64_decode($img);
            file_put_contents($this->filePath."/".$fileName,$file);
        }
        if ($request->has('File2'))
        {
            $fileName2 = time()."-back.png";
            $img = substr($request->File2,strpos($request->File2,',')+1);
            $file = base64_decode($img);
            file_put_contents($this->filePath."/".$fileName2,$file);
        }
        if ($request->has('DocumentTypeId') && $request->only('DocumentTypeId') !== 1){
            CustomerDocument::where('customer_id',$request->only('customer_id'))->where('DocumentTypeId',1)->update(['Status'=> 0]);
        }
        if ($request->has('DocumentTypeId') && $request->only('DocumentTypeId') !== 2){
            CustomerDocument::where('customer_id',$request->only('customer_id'))->where('DocumentTypeId',2)->update(['Status'=> 0]);
        }
        if ($request->has('DocumentTypeId') && $request->only('DocumentTypeId') !== 3){
            CustomerDocument::where('customer_id',$request->only('customer_id'))->where('DocumentTypeId',3)->update(['Status'=> 0]);
        }

        $document = CustomerDocument::create(
            $request->validated()
            +
            ['DocumentPath' => $fileName]
            +
            ['DocumentPath2' => $fileName2]
        );

        return response($document);
    }
}
