<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\purchase;
use App\Models\Sales;
use PDF;
class PDFController extends Controller
{   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       //
     
       
       $invoice = Invoice::find($request->invoice_id);
      
       return view('pdf.invoice',compact('invoice'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {    
       
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       //
       
       $activity = Activities::all();
       $pacel = Pacel::find($id);
      
       return view('invoice_pdf.requisition',compact('activity','pacel'));
     
       
   }
   
       public function pdfview(Request $request)
    {
        $purchase = purchase::find($request->id);
        $sales = Sales::find($request->invoice_id);
        view()->share(['purchases'=>$purchase,'sales'=>$sales]);


        if($request->has('download')){
            if($request->type =="invoice"){
                $pdf = PDF::loadView('pdf.invoice_pdf')->setPaper('a4', 'landscape');
                return $pdf->download('invoice.pdf');
            }
            else{
               $pdf = PDF::loadView('pdf.purchase_pdf')->setPaper('a4', 'landscape');
            return $pdf->download('purchase.pdf'); 
            }
            
        }


        return view('pdfview');
    }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
       //
      

      
   }



   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       //

       
   }
}
