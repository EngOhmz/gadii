<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Manufacturing\Inventory;
use App\Models\Manufacturing\InventoryHistory;
use App\Models\InventoryPayment;
use App\Models\JournalEntry;
use App\Models\Manufacturing\Location;
use App\Models\Payment_methodes;
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

        $billofmaterial=BillOfMaterial::all();
      
        $name = Inventory::all()->where('product_type',2);
        $location = Location::all()->where('store_type',3);
        $work_centre = Location::all()->where('store_type',1);
         $item = Inventory::all()->where('product_type',1);
        $type="";
       return view('manufacturing.bill_of_material',compact('name','billofmaterial','location','type','item','work_centre'));
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

        $data['reference_no']='1';
        $data['manufactured_item']=$request->manufactured_item;
       
   
        $data['work_centre']=$request->work_centre1;
      
        $data['added_by']= auth()->user()->id;

        $purchase = BillOfMaterial::create($data);
        


        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $descriptionArr = $request->description;
        $locationArr = $request->location;
        $work_centreArr = $request->work_centre;
        $unitArr = $request->unit  ;
       

        
        $savedArr =$request->item_name ;
        
     
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $items = array(
                        
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        
                          'location' =>   $locationArr[$i],
                          
                            'work_centre' =>   $work_centreArr[$i],
                        
                         'unit' => $unitArr[$i],
                       
                         'items_id' => $savedArr[$i],

                           'added_by' => auth()->user()->id,
                        'bill_of_material_id' =>$purchase->id);
                       
                     BillOfMaterialInventory::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "BOF_NO-".$purchase->id;
            
            BillOfMaterial::where('id',$purchase->id)->update($cost);
        }    

        
        return redirect(route('purchase_inventory.show',$purchase->id));
        
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
       
 
        $name = Inventory::all()->where('product_type',2);
       $location = Location::all()->where('store_type',3);
        $data=BillOfMaterial::find($id);
        $items=BillOfMaterialInventory::where('bill_of_material_id',$id)->get();
        
        $work_centre = Location::all()->where('store_type',1);
         $item = Inventory::all()->where('product_type',1);
        $type="";
       return view('manufacturing.bill_of_material',compact('name','work_centre','location','data','id','items','item','type'));
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
               $data['reference_no']='1';
        $data['manufactured_item']=$request->manufactured_item;
       
   
        $data['work_centre']=$request->work_centre1;
      
        $data['added_by']= auth()->user()->id;

        $purchase->update($data);
        
        
         $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $descriptionArr = $request->description;
        $locationArr = $request->location;
        $work_centreArr = $request->work_centre;
        $unitArr = $request->unit  ;
        $remArr = $request->removed_id ;

        
        $savedArr =$request->item_name ;
        
           if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                PurchaseItemInventory::where('id',$remArr[$i])->delete();        
                   }
               }
           }
     
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $items = array(
                        
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        
                          'location' =>   $locationArr[$i],
                          
                            'work_centre' =>   $work_centreArr[$i],
                        
                         'unit' => $unitArr[$i],
                       
                         'items_id' => $savedArr[$i],

                           'added_by' => auth()->user()->id,
                        'bill_of_material_id' =>$purchase->id);
                       
                 
                     
                      BillOfMaterialInventory::where('id',$expArr[$i])->update($items);  
    
    
                }
            }
            $cost['reference_no']= "BOF_NO-".$purchase->id;
            
            BillOfMaterial::where('id',$id)->update($cost);
        }    
        
       

      
        return redirect(route('bill_of_material.show',$id));

    



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
               $price= Inventory::where('id',$request->id)->get();
                return response()->json($price);	                  

    }

    public function approve($id)
    {
        //
        $purchase = PurchaseInventory::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = PurchaseInventory::find($id);
        $data['status'] = 4;
        $purchase->update($data);
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Cancelled Successfully']);
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
        $purchases = PurchaseInventory::find($request->id);
        $purchase_items=PurchaseItemInventory::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('inventory.purchase_inv_pdf')->setPaper('a4', 'landscape');
         return $pdf->download('PURCHASE_INVENTORY REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
}
