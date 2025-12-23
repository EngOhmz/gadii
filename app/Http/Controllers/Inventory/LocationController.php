<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use App\Models\LocationManager;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $location= Location::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
         $user= User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
      
       return view('inventory.location',compact('location','user'));
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
        $data['type']='3';
        $data['added_by']=auth()->user()->added_by;
        $location = Location::create($data);

 $nameArr =$request->manager ;


             if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $items = array(
                        'manager' => $nameArr[$i],
                        'name' =>   $request->name,
                       'main' =>   $request->main,
                       'location_id'=>$location->id,
                         'order_no' => $i,
                        'added_by' => auth()->user()->added_by);
                       
                      $manager = LocationManager::create($items);
    
    
                }
            }
        }    


    
 
        return redirect(route('location.index'))->with(['success'=>'Location Created Successfully']);
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
        $data =  Location::find($id);
       $items =  LocationManager::where('location_id',$id)->get();
        $user= User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
        return view('inventory.location',compact('data','id','user','items'));
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
        $location=  Location::find($id);

        $data=$request->post();
        $data['added_by']=auth()->user()->added_by;
        $location->update($data);


      $nameArr =$request->manager ;
     $remArr = $request->removed_id ;
     $expArr = $request->saved_items_id ;


  if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   LocationManager::where('id',$remArr[$i])->delete();        
                       }
                   }
               }

             if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $items = array(
                        'manager' => $nameArr[$i],
                        'name' =>   $request->name,
                       'main' =>   $request->main,
                       'location_id'=>$id,
                         'order_no' => $i,
                        'added_by' => auth()->user()->added_by);

                        if(!empty($expArr[$i])){
                                 LocationManager::where('id',$expArr[$i])->update($items);  
          
          }
          else{
             LocationManager::create($items);   
          }
                      
    
    
                }
            }
        }   

 
        return redirect(route('location.index'))->with(['success'=>'Location Updated Successfully']);
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
        $location=  Location::find($id);
        $data['disabled']=1;
        $location->update($data);

        $manager=  LocationManager::where('location_id',$id)->first();
         $items['disabled']=1;
        $manager->update($items);
 
        return redirect(route('location.index'))->with(['success'=>'Location Deleted Successfully']);
    }
}
