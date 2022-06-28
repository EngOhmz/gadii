<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\User;
use App\Models\Maintainance;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;
use App\Models\Truck;
use App\Models\ServiceType;
use App\Models\Service;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\RequisitionItem;

class MaintainanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
  
        $maintain=Maintainance::all();
        $truck = Truck::all(); 
        $staff=FieldStaff::all();
       //$staff=User::where('id','!=','1')->get();  
      $name =ServiceType::all();
      $item =  Inventory::all(); 
       return view('inventory.maintainance',compact('maintain','truck','staff','name','item'));
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
        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['status']='0';
        $data['added_by']=auth()->user()->added_by;
        $data['truck_name']=$driver->truck_name;
        $data['reg_no']=$driver->reg_no;
        $maintain= Maintainance::create($data);
 
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Created Successfully']);
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

        $data=Maintainance::find($id);
        $truck = Truck::all(); 
       $staff=FieldStaff::all();
      //$staff=User::where('id','!=','1')->get();
   $name = ServiceType::all();
      $item =  Inventory::all(); 
       return view('inventory.maintainance',compact('data','truck','staff','id','name','item'));
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
        $maintain =  Maintainance::find($id);

        $data = $request->all();
        $driver=Truck::where('id',$request->truck)->first();
        $data['driver']=$driver->driver;
        $data['truck_name']=$driver->truck_name;
        $data['reg_no']=$driver->reg_no;
        $data['added_by']=auth()->user()->added_by;
        $maintain->update($data);
 
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Updated Successfully']);
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

        $maintain =  Maintainance::find($id);
        $maintain->delete();
 
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Deleted Successfully']);
    }

    public function approve($id)
    {
        //
        $maintain = Maintainance::find($id);
        $data['status'] = 1;
        $maintain->update($data);
        return redirect(route('maintainance.index'))->with(['success'=>'Maintainance Completed Successfully']);
    }

        public function save_report(Request $request)
    {
        //

        $nameArr =$request->item_name ;
     
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $items = array(
                        'item_name' => $nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                          'date' =>$request->date,
                         'module' =>$request->module,
                        'module_id' =>$request->module_id);
                       
                    MechanicalItem::create($items);  ;
    
    
                }
            }
           
        }    

                $recArr =$request->recommedation ;
     
        if(!empty($recArr)){
            for($i = 0; $i < count($recArr); $i++){
                if(!empty($recArr[$i])){

                    $lists = array(
                        'recommedation' => $recArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                           'date' =>$request->date,
                         'module' =>$request->module,
                        'module_id' =>$request->module_id);
                       
                   MechanicalRecommedation::create($lists);  ;
    
    
                }
            }
           
        } 
        
     if($request->module == 'maintainance'){
        $maintain = Maintainance::find($request->module_id);
        $data['report'] = 2;
        $maintain->update($data);
      
      return redirect(route('maintainance.index'))->with(['success'=>'Mechanical Report Created Successfully']);
       }
 
      elseif($request->module == 'service'){
        $service=Service::find($request->module_id);
        $data['report'] = 2;
        $service->update($data);
      
      return redirect(route('service.index'))->with(['success'=>'Mechanical Report Created Successfully']);
       }
 
    }

 public function save_requisition(Request $request)
    {
        //

       $amountArr = str_replace(",","",$request->amount);
        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;    
        $costArr = str_replace(",","",$request->total_cost)  ;


     if(!empty($nameArr)){
            for($i = 0; $i < 1; $i++){
                if(!empty($nameArr[$i])){

                    $lists= array(
                        'purchase_date' => $request->date,
                        'module' =>   $request->module,
                        'module_id' =>   $request->module_id,  
                        'purchase_amount' =>   $amountArr[$i], 
                          'due_amount' =>   $amountArr[$i],    
                       'status' =>   '0',                  
                        'added_by' => auth()->user()->added_by);
                       
                     $purchase=Requisition::create($lists);  ;
    
    
                }
            }
        }    


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                         'items_id' => $nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'purchase_id' =>$purchase->id);
                       
                    RequisitionItem::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "REQ_".$purchase->id."_".$purchase->purchase_date;
           Requisition::where('id',$purchase->id)->update($cost);
        }    

  if($request->module == 'Maintainance'){
        $maintain = Maintainance::find($request->module_id);
        $data['report'] = 1;
        $maintain->update($data);
      
      return redirect(route('maintainance.index'))->with(['success'=>'Requisition Created Successfully']);
       }
 
      elseif($request->module == 'Service'){
        $service=Service::find($request->module_id);
        $data['report'] = 1;
        $service->update($data);
      
      return redirect(route('service.index'))->with(['success'=>'Requisition Created Successfully']);
       }

    }




}
