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
       $staff=FieldStaff::all();
         //$staff=User::where('id','!=','1')->get();
        $truck_s=TruckTyre::where('status','!=','0')->get();
        $truck=TruckTyre::all();
        $reallocation= TyreReallocation::all();
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
     if($request->source_truck != $request->destination_truck){
        $data=$request->post();
        $name=Tyre::where('id',$request->tyre_id)->first();

         $data['position']=$name->position;
        $data['added_by']=auth()->user()->id;
        $data['status']='0';

         if(!empty($request->destination_tyre)){
          $dest=Tyre::find($request->destination_tyre);
          if($name->position != $dest->postion ){
               return redirect(route('tyre_reallocation.index'))->with(['error'=>'You have chosen tires of different Position. Select again']);
}
}
        $tyre = TyreReallocation::create($data);



        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->id,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Reallocation',
                    'activity'=>"Reallocation of Tyre " .$name->reference. " is Created",
                    'date'=>$request->date,
                ]
                );                      
    }

            return redirect(route('tyre_reallocation.index'))->with(['success'=>'Tyre Reallocation Created Successfully']);
}

else{
    return redirect(route('tyre_reallocation.index'))->with(['error'=>'Source and Destination cannot be the same']);

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
       $staff=FieldStaff::all();
         //$staff=User::where('id','!=','1')->get();
        $truck_s=TruckTyre::where('status','!=','0')->get();
        $truck=TruckTyre::all();
        $data= TyreReallocation::find($id);
         $list= Tyre::where('truck_id',$data->source_truck)->where('status','1')->get();
        $dest_list= Tyre::where('truck_id',$data->destination_truck)->where('status','1')->get();
       return view('tyre.good_reallocation',compact('data','staff','truck','truck_s','id','list'));
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

        if($request->source_truck != $request->destination_truck){
            $tyre= TyreReallocation::find($id);

            $data=$request->post();
            $name=Tyre::where('id',$request->tyre_id)->first();

         $data['position']=$name->position;
        $data['added_by']=auth()->user()->id;
        $data['status']='0';

              if(!empty($request->destination_tyre)){
          $dest=Tyre::find($request->destination_tyre);
          if($name->position != $dest->postion ){
               return redirect(route('tyre_reallocation.index'))->with(['error'=>'You have chosen tires of different Position. Select again']);
}
}

            $tyre->update($data);
    
    
    
            if(!empty($tyre)){
                $activity = TyreActivity::create(
                    [ 
                        'added_by'=>auth()->user()->id,
                        'module_id'=>$tyre->id,
                        'module'=>'Tyre Reallocation',
                        'activity'=>"Reallocation of Tyre " .$name->reference. " is Updated",
                        'date'=>$request->date,
                    ]
                    );                      
        }
    
                return redirect(route('tyre_reallocation.index'))->with(['success'=>'Tyre Reallocation Updated Successfully']);
    }
    
    else{
        return redirect(route('tyre_reallocation.index'))->with(['error'=>'Source and Destination cannot be the same']);
    
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
        $tyre = TyreReallocation::find($id);

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->id,
                    'module_id'=>$id,
                    'module'=>'Tyre Reallocation',
                    'activity'=>"Tyre Deleted",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}

        $tyre->delete();
        return redirect(route('tyre_reallocation.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function approve($id){
        //
        $tyre = TyreReallocation::find($id);
        $data['status'] = 1;
        $tyre->update($data);
        
       Tyre::where('id',$tyre->tyre_id)->update(['truck_id' => $tyre->destination_truck]);
      TyreAssignment::where('tyre_id',$tyre->tyre_id)->update(['truck_id' => $tyre->destination_truck]);  ;

       Truck::where('id',$tyre->source_truck)->update(['tyre' => NULL,'staff'=> NULL,'reading'=>$tyre->source_reading,'position' => NULL]);

      $source_truck = TruckTyre::where('truck_id',$tyre->source_truck)->first();
         if($tyre->position =='Diff'){ 
            $source['due_diff']= $source_truck->due_diff +1;
}
   elseif($tyre->position =='Rear'){ 
          $source['due_rear']= $source_truck->due_rear  +1;
}
  else if($tyre->position =='Trailer'){ 
            $source['due_trailer']= $source_truck->due_trailer+1;
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



      
       if(!empty($tyre->destination_tyre)){
     
         $list['position']=NULL;
        $list['truck_id']=NULL;
        $list['status']='2';
        Tyre::where('id',$tyre->destination_tyre)->update($list);

    
        $name=Tyre::where('id',$tyre->destination_tyre)->first();

        $inv=TyreBrand::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
        TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

            TyreAssignment::where('tyre_id',$tyre->destination_tyre)->delete();

        Truck::where('id',$tyre->destination_truck)->update(['reading'=>$tyre->destination_reading]);
          TruckTyre::where('truck_id',$tyre->destination_truck)->update(['reading'=>$tyre->destination_reading]);  

       }


       elseif(empty($tyre->destination_tyre)){     

        Truck::where('id',$tyre->destination_truck)->update(['reading'=>$tyre->destination_reading]);

 $destination_truck = TruckTyre::where('truck_id',$tyre->destination_truck)->first();
         if($tyre->position =='Diff'){ 
            $destination['due_diff']= $destination_truck->due_diff -1;
}
   elseif($tyre->position =='Rear'){ 
          $destination['due_rear']= $destination_truck->due_rear  -1;
}
  else if($tyre->position =='Trailer'){ 
            $destination['due_trailer']= $destination_truck->due_trailer-1;
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
        

        
       $a=Tyre::where('id',$tyre->tyre_id)->first();

        if(!empty($tyre)){
           $activity = TyreActivity::create(
               [ 
                   'added_by'=>auth()->user()->id,
                   'module_id'=>$tyre->id,
                   'module'=>'Tyre Reallocation',
                   'activity'=>"Reallocation of Tyre " .$a->reference. " is Approved",
                   'date'=>date('Y-m-d'),

               ]
               );                      
}
 
        return redirect(route('tyre_reallocation.index'))->with(['success'=>'Return of Tyre Approved Successfully']);
    }


}
