<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\Location;
use App\Models\Truck;
use App\Models\Tyre\Tyre;
use App\Models\Tyre\TyreActivity;
use App\Models\Tyre\TyreBrand;
use App\Models\Tyre\TyreReturn;
use App\Models\Tyre\TyreReturnItems;
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\TyreAssignment;
use App\Models\Tyre\MasterHistory;
use Illuminate\Http\Request;

class TyreReturnController extends Controller
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
        $location=Location::where('added_by',auth()->user()->added_by)->get();
        $truck=TruckTyre::where('status','!=','0')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $return= TyreReturn::where('added_by',auth()->user()->added_by)->get();
       return view('tyre.good_return',compact('return','staff','location','truck'));
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
       
        $count=TyreReturn::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $dt=date('m/d', strtotime($request->date));
       
       $truck=Truck::find($request->truck_id);
       
        $data['name']='TRN/'.$truck->reg_no.'/'.$dt.'/00'.$pro;
        $data['truck_id']=$request->truck_id;
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['added_by']=auth()->user()->added_by;
        $data['status']='0';

        $tyre = TyreReturn::create($data);
        

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=Tyre::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'truck_id'=>$request->truck_id,
                        'location'=>$b->location,   
                        'quantity' =>    $qtyArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                        'return_id' =>$tyre->id);

                    
                   TyreReturnItems::create($items);

    
                }
            }

           
        }
       
       

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Return',
                    'activity'=>"Return of Tyre with reference " .$tyre->name. " is Created",
                    'date'=>$request->date,
                ]
                );                      
    }
     
            return redirect(route('tyre_return.index'))->with(['success'=>'Return Created Successfully']);
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
        $data= TyreReturn::find($id);
        $items=TyreReturnItems::where('return_id',$id)->get();
        $staff=FieldStaff::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         //$staff=User::where('id','!=','1')->get();
        $location=Location::where('added_by',auth()->user()->added_by)->get();
        $truck=TruckTyre::where('status','!=','0')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       $list= Tyre::where('truck_id',$data->truck_id)->where('status','3')->where('added_by',auth()->user()->added_by)->get();
      
       return view('tyre.good_return',compact('data','staff','location','truck','id','list','items'));
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
        $tyre= TyreReturn::find($id);

 
        $data['truck_id']=$request->truck_id;
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['added_by']=auth()->user()->added_by;
        $data['status']='0';

        $tyre->update($data);
        

        $nameArr =$request->item_id ;
        $qtyArr =$request->quantity ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
              TyreReturnItems::where('id',$remArr[$i])->delete();   
                            
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                     $b=Tyre::find($nameArr[$i]);
                    $items = array(
                        'item_id' => $nameArr[$i],
                         'brand_id' => $b->brand_id,
                        'status' => 0,
                        'truck_id'=>$request->truck_id,
                        'location'=>$b->location,   
                        'quantity' =>    $qtyArr[$i],
                         'order_no' => $i,
                         'added_by' => auth()->user()->added_by,
                        'return_id' =>$id);

                     if(!empty($expArr[$i])){
                    TyreReturnItems::where('id',$expArr[$i])->update($items);                              
                             }
                          else{
                    TyreReturnItems::create($items);  
                       
                          }   
                    
                 
    
                }
            }

           
        }
       
       

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Return',
                    'activity'=>"Return of Tyre with reference " .$tyre->name. " is Updated",
                    'date'=>$request->date,
                ]
                );                      
    }
     

      
            return redirect(route('tyre_return.index'))->with(['success'=>'Tyre Return Updated Successfully']);
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

        $tyre = TyreReturn::find($id);
        

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->added_by,
                    'module_id'=>$id,
                    'module'=>'Tyre Return',
                    'activity'=>"Tyre Deleted",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}

        TyreReturnItems::where('return_id',$id)->delete();
        $tyre->delete();
        return redirect(route('tyre_return.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Tyre::where('truck_id',$request->id)->where('status','3')->get();
                return response()->json($price);                      

    }

    public function approve($id){
        //
        $tyre = TyreReturn::find($id);
        $dt['status'] = 1;
        $tyre->update($dt);
        
            $items= TyreReturnItems::where('return_id',$id)->get();

            foreach($items as $i){

        $name=Tyre::where('id',$i->item_id)->first();

        $list['truck_id']=NULL;
         $list['position']=NULL;
        $list['status']='0';
        Tyre::where('id',$i->item_id)->update($list);
        
        
        $inv=TyreBrand::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
        TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

        //Truck::where('id',$tyre->truck_id)->update(['tyre' => NULL,'staff'=> NULL,'position' => NULL,'reading'=> NULL]);

            $assign=TyreAssignment::where('tyre_id',$i->item_id)->first()  ;

         $truck = TruckTyre::where('truck_id',$tyre->truck_id)->first();
         
        if($assign->position =='Position 1'){ 
            $data['due_1']= $truck->due_1 +1;
            }
        elseif($assign->position =='Position 2'){ 
            $data['due_2']= $truck->due_2 +1;
        }
        elseif($assign->position =='Position 3'){ 
            $data['due_3']= $truck->due_3 +1;
        }
        elseif($assign->position =='Position 4'){ 
            $data['due_4']= $truck->due_4 +1;
        }
        elseif($assign->position =='Position 5'){ 
            $data['due_5']= $truck->due_5 +1;
        }
        elseif($assign->position =='Position 6'){ 
            $data['due_6']= $truck->due_6 +1;
        }
 
                 
                   $data['due_tyre']=$truck->due_tyre +1;

               if($truck->total_tyre == $truck->due_tyre +1){
                     $data['status']='0';
                      $data['staff']=NULL;
}

else{
  $data['status']='1';
}
                      
                     $truck->update($data);
                     
                     $m=MasterHistory::where('serial_id',$i->item_id)->where('other_id',$assign->id)->where('type','Good Assignment')->first();
                     
                     if(!empty($m)){
                        $price=$m->price; 
                     }
  
                   else{
                       $price=$inv->price;  
                   }
  
   $mlists = [
                        'in' => 1,
                        'price' =>$price ,
                        'item_id' => $i->brand_id,
                        'serial_id' =>$i->item_id,
                         'staff_id' => $tyre->staff,
                        'added_by' => auth()->user()->added_by,
                        'location' =>   $i->location,
                        'date' =>$tyre->date,
                        'type' =>   'Return Good Assignment',
                        'other_id' =>$tyre->id,
                    ];

                    MasterHistory::create($mlists);
                     

TyreAssignment::where('tyre_id',$i->item_id)->delete()  ;



}



        if(!empty($tyre)){
           $activity = TyreActivity::create(
               [ 
                   'added_by'=>auth()->user()->added_by,
                   'module_id'=>$tyre->id,
                   'module'=>'Tyre Return',
                   'activity'=>"Return of Tyre with reference " .$tyre->reference. " is Approved",
                   'date'=>date('Y-m-d'),

               ]
               );                      
}
 
        return redirect(route('tyre_return.index'))->with(['success'=>'Return of Tyre Approved Successfully']);
    }

}
