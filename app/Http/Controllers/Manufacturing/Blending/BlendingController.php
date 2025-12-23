<?php

namespace App\Http\Controllers\Manufacturing\Blending;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\Location;
use App\Models\Manufacturing\Blending\Alcohol;
use App\Models\Manufacturing\Blending\Line;
use App\Models\Manufacturing\Blending\Flavor;
use App\Models\Manufacturing\Blending\Type; 
use App\Models\Manufacturing\BillOfMaterial;
use App\Models\Manufacturing\BillOfMaterialInventory;
use App\Models\Manufacturing\MaterialUsed;
use App\Models\Manufacturing\FinishingGood;
use App\Models\Manufacturing\Blending\Tank;
use App\Models\Manufacturing\Blending\Pack;
use App\Models\Manufacturing\Blending\Blending;
use App\Models\Payment_methodes;
use App\Models\Manufacturing\Inventory;

use Illuminate\Http\Request;

class BlendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $location= Location::all();
      
    //   return view('manufacturing.location',compact('location'));
       
       $tanks = Tank::all();
       $lines = Line::all();
      $type = "tool";
     $flavors = Flavor::all();
       $alcohols = Alcohol::all();
        $blend = Blending::all()->where('status','!=',1);
       
       $products =Type::all();
       $packs = Pack::all();
        return view('manufacturing.blending.blending',compact('tanks','lines','type','flavors','alcohols','products','packs','blend','location'));
    }
    
        public function blending_report()
    {
        //
    //     $location= Location::all();
      
    //   return view('manufacturing.location',compact('location'));
       
       $tanks = Tank::all();
       $lines = Line::all();
      $type = "tool";
     $flavors = Flavor::all();
       $alcohols = Alcohol::all();
        $blend = Blending::all()->where('status','!=',1);
       
       $products =Type::all();
       $packs = Pack::all();
        return view('manufacturing.blending.blending_report',compact('tanks','lines','type','flavors','alcohols','products','packs','blend'));
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
        $data = $request->all();
        
        if($data['flavour_id'] == 3982 && $data['alcohol_id'] == 40 ){
            
            $data['blend_volume'] = $data['drums'] * 600;
        }else{
            $data['blend_volume'] = $data['drums']* 631.5625;
        }
        
       $data['target_litres'] = $data['blend_volume'] ;
       
       if(($data['pack_id'] == 1 || $data['pack_id'] == 3)){
           $data['target_cartons'] = $data['blend_volume']/6 ;
       }
       elseif($data['pack_id'] == 2  ){
           $data['target_cartons'] = $data['blend_volume']/9 ;
       }
         
         $inventory =  Inventory::where('name',$data['flavour_id'])->get()->first();
        $inventory =  Inventory::where('name',$data['flavour_id'])->update(['quantity'=>($inventory->quantity - 1)]);
        
        $inventory =  Inventory::where('name','drums')->get()->first();
        
         $inventory =  Inventory::where('name','drums')->update(['quantity'=>($inventory->quantity - $data['drums'])]);
        
        
        $blending = Blending::create($data);

if(!empty($blending)){

       $flavor=Inventory::where('name','Flavour')->first();
      $drums=Inventory::where('name','drums')->first();

 $total=($flavor->price * 1) + ($drums->price * $data['drums']);

         $stock= AccountCodes::where('account_name','Inventory')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$blending->created_at);
          $journal->date =   $blending->created_at ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'blending';
          $journal->name = 'Blending';
          $journal->credit =  $total;
          $journal->income_id= $blending->id;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Reduce Stock  for Blending" ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Production Cost')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
         $date = explode('-',$blending->created_at);
          $journal->date =   $blending->created_at ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'blending';
          $journal->name = 'Blending';
          $journal->debit =  $total;
          $journal->income_id= $inv->id;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Cost for Blending" ;
          $journal->save();




}
        
        return redirect(route('blending.index'))->with(['success'=>"blending created successfully"]);
        
        
        
        
       
      
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
         $type ="tool";
        if($type == "tool"){
            $data=Tank::find($id);
            return view('manufacturing.blending.edit_tank',compact('data','type','id'));
        }elseif($type == "line"){
          $data=Line::find($id);
          return view('manufacturing.blending.edit_line',compact('data','type','id'));
        }
        elseif($type == "flavor"){
          $data=Flavor::find($id);
          return view('manufacturing.blending.edit_batch',compact('data','type','id'));
        }
        elseif($type == "alcohol"){
          $data=Alcohol::find($id);
          return view('manufacturing.blending.edit_alcohol',compact('data','type','id'));
        }
        elseif($type == "product"){
          $data=Type::find($id);
          return view('manufacturing.blending.edit_product',compact('data','type','id'));
        }
        else{
          $data=Pack::find($id);
          return view('manufacturing.blending.edit_pack',compact('data','type','id'));
        }

        // $farmer = Farmer::all();

        return view('manufacturing.blending.settings',compact('data','type','id'));
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
        
        if($request->type == "line"){

        $lines = Line::find($id);
        $lines->update($request->all());
        
        return redirect(route('blending.index'))->with(['success'=>'Line Number updated successfully']);

      }
      elseif($request->type == "flavor"){
          $flavors = Flavor::find($id);
          
         $flavors->update($request->all());
            
            
          return redirect(route('blending.index'))->with(['success'=>'flavor batch updated successfully']);
      }
      
      elseif($request->type == "alcohol"){
         $alcohols = Alcohol::find($id); 
         $alcohols->update($request->all());
         return redirect(route('blending.index'))->with(['success'=>'Alcohol Percentage  updated successfully']);
      }
      
      elseif($request->type == "product"){
          $products = Type::find($id);
          $products->update($request->all());
          return redirect(route('blending.index'))->with(['success'=>'Product Type  updated successfully']);
      }
      
      elseif($request->type == "pack"){
          $packs = Pack::find($id);
          $packs->update($request->all());
          return redirect(route('blending.index'))->with(['success'=>'Pack Size  updated successfully']);
      }
      
      else{
          
        $tanks = Tank::find($id);
        $tanks->update($request->all());
            
          return redirect(route('blending.index'))->with(['success'=>'Tank Number  updated successfully']);
          
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if($request->type == "line"){

        $lines = Line::find($id);
        $lines->delete();
        
        return redirect(route('blending.index'))->with(['success'=>'Line Number deleted successfully']);

      }
      elseif($request->type == "flavor"){
          $flavors = Flavor::find($id);
          
         $flavors->delete();
            
            
          return redirect(route('blending.index'))->with(['success'=>'flavor batch deleted successfully']);
      }
      
      elseif($request->type == "alcohol"){
         $alcohols = Alcohol::find($id); 
         $alcohols->delete();
         return redirect(route('blending.index'))->with(['success'=>'Alcohol Percentage  deleted successfully']);
      }
      
      elseif($request->type == "product"){
          $products = Type::find($id);
          $products->delete();
          return redirect(route('blending.index'))->with(['success'=>'Product Type  deleted successfully']);
      }
      
      elseif($request->type == "pack"){
          $packs = Pack::find($id);
          $packs->delete();
          return redirect(route('blending.index'))->with(['success'=>'Pack Size  deleted successfully']);
      }
      
      else{
          
        $tanks = Tank::find($id);
        $tanks->delete();
            
          return redirect(route('blending.index'))->with(['success'=>'Tank Number  deleted successfully']);
          
      }
      
    }
    
    public function closing(Request $request){
        $id = $request->id;
        $blending = Blending::find($id);
        $blending->status =1;
        $blending->save();
        
            return redirect()->back()->with(['success'=>'blending closed successfully']);
        
    }
    
       public function packing(Request $request){
        
        $id = $request->id;
        $cartons = $request->cartons;
        $blending = Blending::find($id);
        
          $billOfMaterial = BillOfMaterial::where('manufactured_item',$blending->product_id)->where('pack_size_id',$blending->pack_id)->get()->first();
            
            
            $inv = BillOfMaterialInventory::where('bill_of_material_id',!empty($billOfMaterial)? $billOfMaterial->id :'')->get();
        
            
            if(count($inv) > 0){
                
             FinishingGood::create([
            'blending_id'=>$id,
            'product_id'=>$blending->product_id,
            'line_id'=>$blending->line_id,
            'pack_id'=>$blending->pack_id,
            'produced_quantity'=>$id,
            ]);
                 foreach($inv as $row){
                
            MaterialUsed::create([
            'blending_id'=>$id,
            'product_id'=>$blending->product_id,
            'batch_no'=>$blending->batch_no,
            'line_id'=>$blending->line_id,
            'pack_id'=>$blending->pack_id,
            'inventory_id'=>$row->item_name,
            'quantity'=>$row->quantity*$bottles,
            ]);  

        $items= Inventory::find($row->item_name);

        $stock= AccountCodes::where('account_name','Finish Goods')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$blending->created_at);
          $journal->date =   $blending->created_at ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'packing';
          $journal->name = 'Packing';
          $journal->credit = $cartons *  ($row->quantity* $items->price);
          $journal->income_id= $id;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Reduce Stock  for Blending" ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Sales')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
         $date = explode('-',$blending->created_at);
          $journal->date =   $blending->created_at ;
          $journal->year = $date[0];
          $journal->month = $date[1];
           $journal->transaction_type = 'packing';
          $journal->name = 'Packing';
          $journal->debit = $cartons *  ($row->quantity* $items->price);
          $journal->income_id= $id;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Cost for Blending" ;
          $journal->save();

            } 
            
            $blending->used_volume = $blending->used_volume + $cartons;
             $blending->actual_cartons = $blending->actual_cartons + $cartons;
            $blending->save();


         

            return redirect()->back()->with(['success'=>'packing saved successfully']);
            
            }else{
                return redirect()->back()->with(['error'=>'Blending with batch no ['.$blending->batch_no.'] Does not Have Bill Of material, Create First Bill Of Material before running this function']);
                
            }
            
          
    }
    /**
     * Show the form for editing the specified resource.
     *d
     * @param  int  $idh
     * @return \Illuminate\Http\Response
     */
     public function packageModal(Request $request, $id)
   {
               $data = Blending::find($id);
               view('manufacturing.blending.package', compact('id','data'));
     
   }
   
   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function packageModalUpdate1(Request $request, $id)
    {
       

        $lines = Blending::find($id);
        
        $lines->update($request->all());
        
        return redirect(route('blending_settings.index'))->with(['success'=>'Line Number updated successfully']);
    }
}
