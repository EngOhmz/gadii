<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentList;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;

use Response;

class EquipmentController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $client = Equipment::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();     
       return view('truck.equipment',compact('client'));
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

      $data=$request->post();
      $data['added_by'] = auth()->user()->added_by;
      $client = Equipment::create($data);


      return redirect(route('equipment.index'))->with(['success'=>'Created Successfully']);
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
       $data =  Equipment::find($id);
       return view('truck.equipment',compact('data','id'));

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
       $client = Equipment::find($id);
       $data=$request->post();
      $data['added_by'] = auth()->user()->added_by;
       $client->update($data);


         
       return redirect(route('equipment.index'))->with(['success'=>'Updated Successfully']);
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

       $client = Equipment::find($id);
 
       $client->update(['disabled'=> '1']);;

       return redirect(route('equipment.index'))->with(['success'=>'Deleted Successfully']);
   }
   
   
   
   
    public function update_equipment(Request $request)
    {
        //
     $item=Equipment::find($request->id);
     $data['quantity'] = $item->quantity + $request->quantity;
     $item->update($data);
        

        $words = preg_split("/\s+/", $item->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);

                         
                       if($request->quantity > 0){
                      $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                
                        for($x = 1; $x <= $request->quantity; $x++){    
                        $name=Equipment::where('id', $request->id)->first();

                    
              
                        $series = array(
                            'serial_no' => $a.$random.$x, 
                            'brand_id' => $request->id,
                            'added_by' => auth()->user()->added_by,
                            'date' =>   $request->date,
                            'status' => '0');
                       
                    
                 EquipmentList::create($series);   

                   
                    }
               
                           }

                    
    return redirect(route('equipment.index'))->with(['success'=>'Updated Successfully']);;
    }
    
   
    
   
}
