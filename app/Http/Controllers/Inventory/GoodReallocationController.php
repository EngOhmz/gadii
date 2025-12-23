<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\GoodReallocation;
use App\Models\GoodReallocationItem;
use App\Models\Inventory;
use App\Models\InventoryList;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Branch;
use App\Models\Truck;
use Illuminate\Http\Request;

class GoodReallocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventory= Inventory::where('added_by',auth()->user()->added_by)->get();
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
        $truck=Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
        $issue= GoodReallocation::where('added_by',auth()->user()->added_by)->get();
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_reallocation',compact('issue','inventory','staff','truck','branch'));
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

        if($request->source_truck == $request->destination_truck){
       return redirect(route('good_reallocation.index'))->with(['error'=>'You have Chosen the same truck']);

}


else{
       
         $count=GoodReallocation::where('added_by', auth()->user()->added_by)->count();
            $pro=$count+1;
            $dt=date('m/d', strtotime($request->date));

        
        $data['movement_date']=$request->date;
        $data['destination_truck']=$request->destination_truck;
        $data['source_truck']=$request->source_truck;    
        $data['staff']=$request->staff;
        $data['name']=$dt.'/00'.$pro;
        $data['costs']=$request->costs;
        $data['branch_id']=$request->branch_id;
        $data['account_id']=$request->account_id;
        $data['description']=$request->description;
        $data['status']= 0;
         $data['user_id']= auth()->user()->added_by;
        $data['added_by']= auth()->user()->added_by;

        $issue = GoodReallocation::create($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;

       $total=0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'destination_truck'=>$request->destination_truck,
                        'source_truck'=>$request->source_truck,   
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'movement_id' =>$issue->id);

                    
                   GoodReallocationItem::create($items);

                    $total+= $qtyArr[$i];

               

    
                }
            }

        GoodReallocation::find($issue->id)->update(['quantity' => $total]);
           
        }    
       
        return redirect(route('good_reallocation.index'))->with(['success'=>'Created Successfully']);
}
      
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
        //
         $inventory= Inventory::where('added_by',auth()->user()->added_by)->get();
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
        $truck=Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get(); 
        $data= GoodReallocation::find($id);
         $items=GoodReallocationItem::where('movement_id',$id)->get();
      $inventory= InventoryList::where('truck_id',$data->source_truck)->where('status','3')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_reallocation',compact('data','inventory','staff','truck','id','inventory','items'));
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
          if($request->source_truck == $request->destination_truck){
       return redirect(route('good_reallocation.index'))->with(['error'=>'You have Chosen the same truck']);

}


else{
        $reallocation =GoodReallocation::find($id);

      
        $data['movement_date']=$request->date;
        $data['destination_truck']=$request->destination_truck;
        $data['source_truck']=$request->source_truck;    
        $data['staff']=$request->staff;
        $data['costs']=$request->costs;
        $data['branch_id']=$request->branch_id;
        $data['account_id']=$request->account_id;
        $data['description']=$request->description;
        $data['status']= 0;
         $data['user_id']= auth()->user()->added_by;
        $data['added_by']= auth()->user()->added_by;

        $reallocation->update($data);
        
       

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

          $total=0;

           
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
              GoodReallocationItem::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=InventoryList::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'destination_truck'=>$request->destination_truck,
                        'source_truck'=>$request->source_truck,   
                        'quantity' =>    $qtyArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'movement_id' =>$id);

                    
                 
                            if(!empty($expArr[$i])){
                               GoodReallocationItem::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                        GoodReallocationItem::create($items);  
                       
                          }   

                    $total+= $qtyArr[$i];

               

    
                }
            }

        GoodReallocation::find($id)->update(['quantity' => $total]);
           
        }    
       
        return redirect(route('good_reallocation.index'))->with(['success'=>'Updated Successfully']);
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
        //
        $reallocation =  GoodReallocation::find($id);
         GoodReallocationItem::where('movement_id',$id)->delete();
        $reallocation->delete();

        return redirect(route('good_reallocation.index'))->with(['success'=>'Good Reallocation  Deleted Successfully']);
    }

    public function approve($id){
        //
        $item =  GoodReallocation::find($id);
        $data['status'] = 1;
       $item->update($data);
       
        $items=GoodReallocationItem::where('movement_id',$id)->get();

foreach($items as $i){


InventoryList::where('id',$i->item_id)->where('added_by',auth()->user()->added_by)->where('status','3')->update(['truck_id' => $i->destination_truck,'staff'=> $item->staff]);


} 
        
    
/*
       if(!empty($item->destination_item)){
        $list['truck_id']=NULL;
        $list['status']='2';
        InventoryList::where('id',$item->destination_item)->update($list);
    
        $name= InventoryList::where('id',$item->destination_item)->first();

        $inv= Inventory::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
        Inventory::where('id',$name->brand_id)->update(['quantity' => $q]);
       }
*/

     
 
        return redirect(route('good_reallocation.index'))->with(['success'=>'Item Reallocation Approved Successfully']);
    }
    
    
    public function getInventory(Request $request)
{
	$list = InventoryList::where('truck_id',$request->id)->where('added_by',auth()->user()->added_by)->where('status',3)->get(); 

	foreach ( $list as $l ) {
		    $og=Inventory::where('id',$l->brand_id)->first();
			$obj['name'] = $og->name.' - '.$l->serial_no;
			$obj['id'] = $l->id;          
			$data[] = $obj;
		}
		
	
	//dd($data);
	return response()->json($data);
}

}
