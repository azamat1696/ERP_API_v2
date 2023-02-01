<?php

namespace App\Http\Controllers;

use App\Models\ForeignSale;
use App\Models\ForeignSaleCollection;
use Illuminate\Http\Request;
use App\Helpers\MoneyToString;
use PDF;
class ForeignSaleController extends Controller
{
    
    public function index() {
        return response()->json(ForeignSale::orderBy('created_at','DESC')->get());
    }

    public function store(Request $request)
    {
        
        $moneyToString = new MoneyToString(
            $request->all()['UnitPrice'],
            '.',
            '₺',
            'Lira'
        );
        
        $foreignSale = ForeignSale::create($request->all() + ['TotalSting' => $moneyToString->formattedMoneyString]);
        ForeignSaleCollection::create([
            'foreign_sale_id' => $foreignSale->id,
            'ReceiptCollectionNo' => $this->lastReceiptCollectionNo(),
            'MessageContent' => $foreignSale->InvoiceNo ." NO'LU "." ".$foreignSale->InvoiceTitle." den/dan  ".$moneyToString->formattedMoneyString ." Teşekkürlerle alınmıştır.",
        ]);
        
        return response()->json(ForeignSale::with('collection')->findOrFail($foreignSale->id)  );
    }

    public function lastReceiptCollectionNo() {
        $lastReceiptCollectionNo =  ForeignSaleCollection::orderBy('created_at', 'desc')->first();
        return ($lastReceiptCollectionNo) ? $lastReceiptCollectionNo->ReceiptCollectionNo +1 : 1 ;
     }
 
    public function update(Request $request) {
         $moneyToString = new MoneyToString( $request->all()['UnitPrice'], '.', '₺', 'Lira');
         $id = $request->id;
         $request->offsetUnset('collection');
         $request->offsetUnset('id');
         $request->offsetUnset('created_at');
         $request->offsetUnset('updated_at');
         $request->offsetUnset('TotalSting');
         $request->offsetUnset('_method');
         $foreignSale =  ForeignSale::findOrFail($id);
         $foreignSale->update( $request->all() + ['TotalSting' => $moneyToString->formattedMoneyString] );
         $foreignSaleCollection = ForeignSaleCollection::where('foreign_sale_id','=',$foreignSale->id)->first();
         $foreignSaleCollection->update([
             'MessageContent' => $foreignSale->InvoiceNo ." NO'LU "." ".$foreignSale->InvoiceTitle." den/dan  ".$moneyToString->formattedMoneyString ." Teşekkürlerle alınmıştır.",
         ]);
        return response()->json(ForeignSale::with('collection')->findOrFail($id));
     }
     
    public function download($id) {
        
         $invoice = ForeignSale::findOrFail($id);
         $personal = auth()->user()->name .' '.auth()->user()->surname;
         $pdf =  PDF::loadView('Corparate.InvoiceSales',
             compact('invoice',
                 'personal'
             ))->setPaper('a4', 'portrait');
         $pdfName = rand(1111111,999999999).".pdf";
        return $pdf->download($pdfName);
     }

    public function downloadReceipt($id) {
        $invoice = ForeignSale::findOrFail($id);
        $receipt = ForeignSaleCollection::where('foreign_sale_id','=',$invoice->id)->first();
     
        $pdf =  PDF::loadView('Corparate.InvoiceSalesReceipt',
            compact('receipt',
                'invoice'
                
            ))->setPaper('a4', 'portrait');
        $pdfName = rand(1111111,999999999).".pdf";
        return $pdf->download($pdfName);
    }
}
