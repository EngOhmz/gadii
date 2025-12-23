<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\Truck;
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\TyreAssignment;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreBrand;
use App\Models\Tyre\TyreReallocation;
use App\Models\Tyre\TyreReallocationItems;
use App\Models\Tyre\MasterHistory;
use Illuminate\Http\Request;

class TyreReallocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       $staff=FieldStaff::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         //$staff=User::where('id','!=','1')->get();
        $truck_s=TruckTyre::where('status','!=','0')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $truck=TruckTyre::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $reallocation= TyreReallocation::where('added_by',auth()->user()->added_by)->get();
       return view('tyre.good_reallocation',compact('reallocation','staff','truck','truck_s'));
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

        $count=TyreReallocation::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
       
       $truck=Truck::find($request->source_truck);
       
        $data['name']='TR/'.$truck->reg_no.'/'.$dt.'/00'.$pro;
        $data['source_truck']=$request->source_truck;
        $data['destination_truck']=$request->destination_truck;
        $data['source_reading']=$request->source_reading;
        $data['destination_reading']=$request->destination_reading;
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['added_by']=auth()->user()->added_by;
        $data['status']='0';

        $tyre = TyreReallocation::create($data);
        
        $sourceArr =$request->source_tyre ;
        $destArr =$request->destination_tyre ;
        $qtyArr =$request->quantity ;


        if(!empty($sourceArr)){
            for($i = 0; $i < count($sourceArr); $i++){
                if(!empty($sourceArr[$i])){

                     $a=Tyre::find($sourceArr[$i]);
                     $b=Tyre::find($destArr[$i]);
                     
                     if(!empty($b)){
                         $br=$b->brand_id;
                     }
                     else{
                        $br='';
                     }
                     
                     
                    $items = array(
                        'source_tyre' => $sourceArr[$i],
                        'destination_tyre' => $destArr[$i],
                        'source_brand' => $a->brand_id,
                        'destination_brand' => $br,
                        'status' => 0,
                        'position'=>$a->position,   
                        'quantity' =>    $qtyArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                        'reallocation_id' =>$tyre->id);

                    
                  TyreReallocationItems::create($items);

    
                }
            }

           
        }



        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Reallocation',
                    'activity'=>"Reallocation of Tyre with reference " .$tyre->name. " is Created",
                    'date'=>$request->date,
                ]
                );                      
    }

            return redirect(route('tyre_reallocation.index'))->with(['success'=>'Tyre Reallocation Created Successfully']);



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

        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();
         //$staff=User::where('id','!=','1')->get();
        $truck_s=TruckTyre::where('status','!=','0')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $truck=TruckTyre::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $data= TyreReallocation::find($id);
         $items=TyreReallocationItems::where('reallocation_id',$id)->get();
         $list= Tyre::where('truck_id',$data->source_truck)->where('status','3')->where('added_by',auth()->user()->added_by)->get();
        $dest_list= Tyre::where('truck_id',$data->destination_truck)->where('status','3')->where('added_by',auth()->user()->added_by)->get();
       return view('tyre.good_reallocation',compact('data','staff','truck','truck_s','id','list','items','dest_list'));
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

            $tyre= TyreReallocation::find($id);
            
        $data['source_truck']=$request->source_truck;
        $data['destination_truck']=$request->destination_truck;
        $data['source_reading']=$request->source_reading;
        $data['destination_reading']=$request->destination_reading;
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['added_by']=auth()->user()->added_by;
        $data['status']='0';

       $tyre->update($data);
        
        $sourceArr =$request->source_tyre ;
        $destArr =$request->destination_tyre ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
              TyreReallocationItems::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }


        if(!empty($sourceArr)){
            for($i = 0; $i < count($sourceArr); $i++){
                if(!empty($sourceArr[$i])){

                     $a=Tyre::find($sourceArr[$i]);
                     $b=Tyre::find($destArr[$i]);
                     
                      if(!empty($b)){
                         $br=$b->brand_id;
                     }
                     else{
                        $br='';
                     }
                     
                    $items = array(
                        'source_tyre' => $sourceArr[$i],
                        'destination_tyre' => $destArr[$i],
                        'source_brand' => $a->brand_id,
                        'destination_brand' => $br,
                        'status' => 0,
                        'position'=>$a->position,   
                        'quantity' =>    $qtyArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                        'reallocation_id' =>$id);

                    if(!empty($expArr[$i])){
                       TyreReallocationItems::where('id',$expArr[$i])->update($items); 
                    }
                    
                    else{
                  TyreReallocationItems::create($items);
                    }

    
                }
            }

           
        }

            
    
    
    
            if(!empty($tyre)){
                $activity = TyreActivity::create(
                    [ 
                        'added_by'=>auth()->user()->added_by,
                        'module_id'=>$tyre->id,
                        'module'=>'Tyre Reallocation',
                        'activity'=>"Reallocation of Tyre " .$tyre->name. " is Updated",
                        'date'=>$request->date,
                    ]
                    );                      
        }
    
                return redirect(route('tyre_reallocation.index'))->with(['success'=>'Tyre Reallocation Updated Successfully']);

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
        $tyre = TyreReallocation::find($id);

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$id,
                    'module'=>'Tyre Reallocation',
                    'activity'=>"Tyre Deleted",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}

        TyreReallocationItems::where('reallocation_id',$id)->delete();
        $tyre->delete();
        return redirect(route('tyre_reallocation.index'))->with(['success'=>'Deleted Successfully']);
    }
    

    public function approve($id){
        //
        $tyre = TyreReallocation::find($id);
        $data['status'] = 1;
        $tyre->update($data);
        
        $items=  TyreReallocationItems::where('reallocation_id',$id)->get();

            foreach($items as $i){
                
        Tyre::where('id',$i->source_tyre)->update(['truck_id' => $tyre->destination_truck]);
      TyreAssignment::where('tyre_id',$i->source_tyre)->update(['truck_id' => $tyre->destination_truck]);  ;

       Truck::where('id',$tyre->source_truck)->update(['tyre' => NULL,'staff'=> NULL,'reading'=>$tyre->source_reading,'position' => NULL]);

      $source_truck = TruckTyre::where('truck_id',$tyre->source_truck)->first();
         if($i->position =='Position 1'){ 
            $source['due_1']= $source_truck->due_1 +1;
            }
        elseif($i->position =='Position 2'){ 
            $source['due_2']= $source_truck->due_2 +1;
        }
        elseif($i->position =='Position 3'){ 
            $source['due_3']= $source_truck->due_3 +1;
        }
        elseif($i->position =='Position 4'){ 
            $source['due_4']= $source_truck->due_4 +1;
        }
        elseif($i->position =='Position 5'){ 
            $source['due_5']= $source_truck->due_5 +1;
        }
        elseif($i->position =='Position 6'){ 
            $source['due_6']= $source_truck->due_6 +1;
        }
 
                 
                   $source['due_tyre']=$source_truck->due_tyre +1;
                 $source['reading']=$tyre->source_reading;

               if($source_truck->total_tyre == $source_truck->due_tyre +1){
                     $source['status']='0';
                      $source['staff']=NULL;
}

else{
  $source['status']='1';
}
                      
                    $source_truck->update($source);



      
       if(!empty($i->destination_tyre)){
     
         $list['position']=NULL;
        $list['truck_id']=NULL;
        $list['status']='0';
        Tyre::where('id',$i->destination_tyre)->update($list);

    
        $name=Tyre::where('id',$i->destination_tyre)->first();

        $inv=TyreBrand::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
        TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);
        
         $assign=TyreAssignment::where('tyre_id',$i->destination_tyre)->first()  ;
          $m=MasterHistory::where('serial_id',$i->destination_tyre)->where('other_id',$assign->id)->where('type','Good Assignment')->first();
                     
                     if(!empty($m)){
                        $price=$m->price; 
                     }
  
                   else{
                       $price=$inv->price;  
                   }
  
   $mlists = [
                        'in' => 1,
                        'price' =>$price ,
                        'item_id' => $name->brand_id,
                        'serial_id' =>$i->destination_tyre,
                         'staff_id' => $tyre->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $name->location,
                        'date' =>$tyre->date,
                        'type' =>   'Good Reallocation',
                        'other_id' =>$id,
                    ];

                    MasterHistory::create($mlists);

        TyreAssignment::where('tyre_id',$i->destination_tyre)->delete();

        Truck::where('id',$tyre->destination_truck)->update(['reading'=>$tyre->destination_reading]);
          TruckTyre::where('truck_id',$tyre->destination_truck)->update(['reading'=>$tyre->destination_reading]);  

       }


       elseif(empty($i->destination_tyre)){     

        Truck::where('id',$tyre->destination_truck)->update(['reading'=>$tyre->destination_reading]);

 $destination_truck = TruckTyre::where('truck_id',$tyre->destination_truck)->first();
        if($i->position =='Position 1'){ 
            $destination['due_1']= $destination_truck->due_1 -1;
            }
        elseif($i->position =='Position 2'){ 
            $destination['due_2']= $destination_truck->due_2 -1;
        }
        elseif($i->position =='Position 3'){ 
            $destination['due_3']= $destination_truck->due_3 -1;
        }
        elseif($i->position =='Position 4'){ 
            $destination['due_4']= $destination_truck->due_4 -1;
        }
        elseif($i->position =='Position 5'){ 
            $destination['due_5']= $destination_truck->due_5 -1;
        }
        elseif($i->position =='Position 6'){ 
            $destination['due_6']= $destination_truck->due_6 -1;
        }
 
                 
                   $destination['due_tyre']=$destination_truck->due_tyre -1;

               if($destination_truck->due_tyre -1 =='0' ){
                     $destination['status']='2';
                    
}

else{
  $destination['status']='1';
}
                        $destination['staff']=$tyre->staff;
                       $destination['reading']=$tyre->destination_reading;
                    $destination_truck->update($destination);

       }
                
                
            }
        
      
        


        if(!empty($tyre)){
           $activity = TyreActivity::create(
               [ 
                   'added_by'=>auth()->user()->added_by,
                   'module_id'=>$tyre->id,
                   'module'=>'Tyre Reallocation',
                   'activity'=>"Reallocation of Tyre " .$tyre->reference. " is Approved",
                   'date'=>date('Y-m-d'),

               ]
               );                      
}
 
        return redirect(route('tyre_reallocation.index'))->with(['success'=>'Reallocation of Tyre Approved Successfully']);
    }





 public function findPosition(Request $request)
    {
        
        for($i = 0; $i < count($request['source_tyre']); $i++){
        //dd($request['destination_tyre'][$i]);
        
        $s=Tyre::find($request['source_tyre'][$i]);
        $d=Tyre::find($request['destination_tyre'][$i]);
        
        if(!empty($request['destination_tyre'][$i])){
          $b=$d->position;
          
        }
        else{
          $b=$s->position;  
        }
        
        
         $range[]=[
            'c'=>$s->position,
            'd'=>$b,
        ];
        
        }
     
//dd($range); 



foreach ($range as $key => $subarr) {
    
    if (count(array_unique($subarr)) === 1) {
       $result[] = 'true';
    } else {
        $result[] = 'false';
    }
}

//print_r($result);

if(count($result) > 1){


  //$test=(count(array_unique($result, SORT_REGULAR)) === 1);
  

if(count(array_unique($result)) === 1) {
    $test= current($result);
} 
  else{
      
  } 
  
//dd($test); 

 if($test != "true")  {
 $price='error';   
 }    

else{
  $price='';    
}

}

else{
    //dd($result[0]);
  if($result[0] != 'true')  {
 $price='error';   
 }    

elseif($result[0] == 'true')  {
  $price='';    
}  
    
}

  

                return response()->json($price);                      

    }




}
