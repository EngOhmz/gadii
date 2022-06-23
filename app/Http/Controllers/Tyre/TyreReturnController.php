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
use App\Models\Tyre\TruckTyre;
use App\Models\Tyre\TyreAssignment;
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

        $staff=FieldStaff::all();
         //$staff=User::where('id','!=','1')->get();
        $location=Location::all();
        $truck=TruckTyre::where('status','!=','0')->get();
        $return= TyreReturn::all();
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
       $name=Tyre::find($request->tyre_id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $data['status']='0';
           $data['location']=$name->location;
        $tyre = TyreReturn::create($data);

       

        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->id,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Return',
                    'activity'=>"Return of Tyre " .$name->reference. " is Created",
                    'date'=>$request->date,
                ]
                );                      
    }
     
            return redirect(route('tyre_return.index'))->with(['success'=>'Tyre Return Created Successfully']);
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
        $staff=FieldStaff::all();
         //$staff=User::where('id','!=','1')->get();
        $location=Location::all();
        $truck=TruckTyre::where('status','!=','0')->get();
       $list= Tyre::where('truck_id',$data->truck_id)->where('status','1')->get();
      
       return view('tyre.good_return',compact('data','staff','location','truck','id','list'));
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

  $name=Tyre::find($request->tyre_id);

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $data['status']='0';
           $data['location']=$name->location;
        $tyre->update($data);


        if(!empty($tyre)){
            $activity = TyreActivity::create(
                [ 
                    'added_by'=>auth()->user()->id,
                    'module_id'=>$tyre->id,
                    'module'=>'Tyre Return',
                    'activity'=>"Return of Tyre " .$name->reference. " is Updated",
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
                    'added_by'=>auth()->user()->id,
                    'module_id'=>$id,
                    'module'=>'Tyre Return',
                    'activity'=>"Tyre Deleted",
                   'date'=>date('Y-m-d'),
                ]
                );                      
}

        $tyre->delete();
        return redirect(route('tyre_return.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Tyre::where('truck_id',$request->id)->where('status','1')->get();
                return response()->json($price);	                  

    }

    public function approve($id){
        //
        $tyre = TyreReturn::find($id);
        $data['status'] = 1;
        $tyre->update($data);

        $name=Tyre::where('id',$tyre->tyre_id)->first();

        $list['truck_id']=NULL;
         $list['position']=NULL;
        $list['status']='2';
        Tyre::where('id',$tyre->tyre_id)->update($list);
        
        
        $inv=TyreBrand::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
        TyreBrand::where('id',$name->brand_id)->update(['quantity' => $q]);

        //Truck::where('id',$tyre->truck_id)->update(['tyre' => NULL,'staff'=> NULL,'position' => NULL,'reading'=> NULL]);

            $assign=TyreAssignment::where('tyre_id',$tyre->tyre_id)->first()  ;

         $truck = TruckTyre::where('truck_id',$tyre->truck_id)->first();
         if($assign->position =='Diff'){ 
            $data['due_diff']= $truck->due_diff +1;
}
   elseif($assign->position =='Rear'){ 
          $data['due_rear']= $truck->due_rear  +1;
}
  else if($assign->position =='Trailer'){ 
            $data['due_trailer']= $truck->due_trailer+1;
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

TyreAssignment::where('tyre_id',$tyre->tyre_id)->delete()  ;

        if(!empty($tyre)){
           $activity = TyreActivity::create(
               [ 
                   'added_by'=>auth()->user()->id,
                   'module_id'=>$tyre->id,
                   'module'=>'Tyre Return',
                   'activity'=>"Return of Tyre " .$name->reference. " is Approved",
                   'date'=>date('Y-m-d'),

               ]
               );                      
}
 
        return redirect(route('tyre_return.index'))->with(['success'=>'Return of Tyre Approved Successfully']);
    }

}
