<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Manufacturing\Inventory;
use App\Models\Manufacturing\InventoryHistory;
use App\Models\InventoryPayment;
use App\Models\JournalEntry;
// use App\Models\Manufacturing\Location;
use App\Models\Payment_methodes;
use App\Models\Manufacturing\Blending\Pack;
use App\Models\Manufacturing\Blending\Type;

use App\Models\Manufacturing\MaterialUsed;
use App\Models\Manufacturing\FinishingGood;
use App\Models\Manufacturing\Blending\Blending;

use  App\Models\POS\Items;
use App\Models\Location;

use App\Models\Purchase_items;
use App\Models\Manufacturing\BillOfMaterial;
use App\Models\Manufacturing\BillOfMaterialInventory;
use App\Models\Supplier;
use App\Models\InventoryList;
use PDF;

use Illuminate\Http\Request;

class  BillOfMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $billofmaterial=BillOfMaterial::all()->where('added_by', auth()->user()->added_by);
      
        $name = Items::all()->where('type',3)->where('added_by', auth()->user()->added_by);
        $locations = Location::all()->where('type',3)->where('added_by', auth()->user()->added_by);
        $products = Items::all()->where('type',2)->where('added_by', auth()->user()->added_by);
         $item = Type::all();
         $pack_size = Pack::all();
        $type="";
       return view('manufacturing.bill_of_material',compact('name','billofmaterial','locations','type','item','products','pack_size'));
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
        //
        
        $count=BillOfMaterial::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $data['reference_no']= "BOF_NO".$pro;

        // $data['reference_no']='1';
        $data['description']=$request->description;
        
        // $data['location_id']=$request->location_id;
        
        $data['product']=$request->product;
        
        $data['status'] = 0;
       
      
        $data['added_by']= auth()->user()->added_by;

        $purchase = BillOfMaterial::create($data);
        


        $nameArr =$request->item_name;
        $qtyArr = $request->quantity;
        // $descriptionArr = $request->description;
        // $locationArr = $request->location;
        // $work_centreArr = $request->work_centre;
        $unitArr = $request->unit;
       

        
        // $savedArr =$request->item_name;
        
       
        
     
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    
                    $itm = Items::where('id',$nameArr[$i])->first();
                    
                    $items = array(
                        
                        'item_name' => $itm->name,
                        'quantity' =>   $qtyArr[$i],
                        
                        //   'location' =>   $locationArr[$i],
                          
                        //     'work_centre' =>   $work_centreArr[$i],
                        
                         'unit' => $unitArr[$i],
                       
                         'items_id' => $itm->id,

                           'added_by' => auth()->user()->added_by,
                        'bill_of_material_id' =>$purchase->id);
                       
                     BillOfMaterialInventory::create($items);  ;
    
    
                }
            }
            // $cost['reference_no']= "BOF_NO-".$purchase->id;
            
            // BillOfMaterial::where('id',$purchase->id)->update($cost);
        }    

        
        return redirect(route('bill_of_material.index'));
        
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
        $bill_of_material = BillOfMaterial::find($id);
        $bill_of_material_item=BillOfMaterialInventory::where('bill_of_material_id',$id)->get();
      
        
        return view('manufacturing.bill_of_material_details',compact('bill_of_material','bill_of_material_item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       
 
        $name = Items::all()->where('type',3)->where('added_by', auth()->user()->added_by);
       $location = Location::all()->where('type',3)->where('added_by', auth()->user()->added_by);
        $data=BillOfMaterial::find($id);
        $items=BillOfMaterialInventory::where('bill_of_material_id',$id)->get();
        
        $work_centre = Location::all()->where('type',1)->where('added_by', auth()->user()->added_by);
         $item = Items::all()->where('type',1)->where('added_by', auth()->user()->added_by);
        $type="";
        $products = Items::all()->where('type',2)->where('added_by', auth()->user()->added_by);
       return view('manufacturing.bill_of_material',compact('name','work_centre','location','data','id','items','item','type','products'));
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


        $purchase = BillOfMaterial::find($id);
            //   $data['reference_no']='1';
               
               $data['description']=$request->description;
        // $data['manufactured_item']=$request->manufactured_item;
        
        $data['product']=$request->product;
        
        $data['status'] = 0;
       
   
        // $data['work_centre']=$request->work_centre1;
      
        $data['added_by']= auth()->user()->added_by;

        $purchase->update($data);
        
        
         $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        // $descriptionArr = $request->description;
        // $locationArr = $request->location;
        // $work_centreArr = $request->work_centre;
        $unitArr = $request->unit  ;
        $remArr = $request->removed_id ;
        
        $expArr = $request->saved_items_id ;

        
        $savedArr =$request->items_id ;
        
           if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                BillOfMaterialInventory::where('id',$remArr[$i])->delete();        
                   }
               }
           }
     
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $itm = Items::where('id',$nameArr[$i])->first();
                    
                    $items = array(
                        
                        'item_name' => $itm->name,
                        'quantity' =>   $qtyArr[$i],
                        
                        //   'location' =>   $locationArr[$i],
                          
                        //     'work_centre' =>   $work_centreArr[$i],
                        
                         'unit' => $unitArr[$i],
                       
                         'items_id' => $itm->id,

                           'added_by' => auth()->user()->added_by,
                        'bill_of_material_id' =>$purchase->id);
                       
                 
                     
                      BillOfMaterialInventory::where('id',$expArr[$i])->update($items);  
    
    
                }
            }
            // $cost['reference_no']= "BOF_NO-".$purchase->id;
            
            // BillOfMaterial::where('id',$id)->update($cost);
        }    
        
       

      
        return redirect(route('bill_of_material.index'));

    



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
        BillOfMaterialInventory::where('bill_of_material_id', $id)->delete();
      //  InventoryPayment::where('purchase_id', $id)->delete();
       //InventoryHistory::where('purchase_id', $id)->delete();
        $purchases = BillOfMaterial::find($id);
        $purchases->delete();
        return redirect(route('bill_of_material.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);	                  

    }
    
    public function packing_model(Request $request){
        
        $id = $request->id;
        return view('manufacturing.packing_model',compact('id'));
        
    }
    
       
    public function packing(Request $request){
        
        $id = $request->id;
        $bottles = $request->bottles;
        $blending = Blending::find($id);
        
        FinishingGood::create([
            'blending_id'=>$id,
            'product_id'=>$blending->product_id,
            'blending_id'=>$blending->line_id,
            'blending_id'=>$blending->pack_id,
            'blending_id'=>$id,
            ]);
        
        echo $id;
    }

    public function approve($id)
    {
        //
        $purchase = BillOfMaterial::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('bill_of_material.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = BillOfMaterial::find($id);
        $data['status'] = 4;
        $purchase->update($data);
        return redirect(route('bill_of_material.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $supplier=Supplier::all();
        $name = Inventory::all();
        $location = Location::all();
        $data=PurchaseInventory::find($id);
        $items=PurchaseItemInventory::where('purchase_id',$id)->get();
        $type="receive";
       return view('inventory.manage_purchase_inv',compact('name','supplier','currency','location','data','id','items','type'));
    }

  public function inventory_list()
    {
        //
        $tyre= InventoryList ::all();
       return view('inventory.list',compact('tyre'));
    }
    public function make_payment($id)
    {
        //
        $invoice = PurchaseInventory::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('inventory.inventory_payment',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //

          $bill_of_material = BillOfMaterial::find($request->id);
        $bill_of_material_item=BillOfMaterialInventory::where('bill_of_material_id',$request->id)->get();
      
        
        view()->share(['bill_of_material'=>$bill_of_material,'bill_of_material_item'=> $bill_of_material_item]);

        if($request->has('download')){
        $pdf = PDF::loadView('manufacturing.bill_of_material_pdf');
         return $pdf->download('BILL OF MATERIAL REF NO # ' .  $bill_of_material->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
}
