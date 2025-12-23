<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Role;
use App\Models\Retail\Supplier;
use App\Models\Retail\Location;
use App\Models\Retail\Purchase;
use App\Models\Retail\PurchaseItems;
use App\Models\Retail\Invoice;
use App\Models\Retail\InvoiceItems;
use App\Models\Retail\Client;
use App\Models\Retail\Activity;
use Illuminate\Support\Facades\Hash;
use App\Models\CompanyRoles;
use App\Models\LocationManager;
//use App\Models\FarmLand;

class ShopkeeperController extends Controller
{
    
    public function shopkeeper($id){
        
         $location = User::where('store_id',$id)->get();

        if($location->isNotEmpty()){
            
            foreach($location as $row){
                
                $data['name'] = $row->name;
          
                $data['email'] = $row->email;
                $data['address'] = $row->address;
                $data['phone'] = $row->phone;
                
                

                $farmers[] = $data;
     
                }
            
            
                
                
                
                
                $response=['success'=>true,'error'=>false,'message'=>'successfully','shopkeeper'=>$farmers];
                return response()->json($response,200);
                
            }
            else{
                
                $response=['success'=>false,'error'=>true,'message'=>'No Shopkeeper found on Store'];
                return response()->json($response,200);
            }

        
        
    }
    
    public function shopkeeper_delete(int $id){
        
        $shopkeeper = User::find($id);

        if(!empty($shopkeeper)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>   $shopkeeper->added_by,
                            'module_id'=>$shopkeeper->id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $shopkeeper->name. "  Deleted",
                        ]
                        );                      
       }

        $crop = $shopkeeper->delete();

        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Shopkeeper deleted'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Shopkeeper'];
            return response()->json($response,200);
        }
    }
    
    public function index($id, $store_id)
    {

        $location = Location::find($store_id); 

       if(!empty($location)){
           

            $purchases = Purchase::where('location', $store_id)->where('status', '!=', 0)->where('added_by', $id)->get();

            foreach($purchases as $row){

                $data = $row;

                $farmers[] = $data;
     
            }
            
             $invoices = Invoice::where('location', $store_id)->where('status', '!=', 0)->where('added_by', $id)->get();


            foreach($invoices as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','supplier'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Supplier found'];
            return response()->json($response,200);
        }

    }

    public function indexOff(int $id, int $lastId)
    {
        
        $supply = Supplier::where('user_id', $id)->where('id', '>', $lastId)->get();

        if($supply->isNotEmpty()){

            foreach($supply as $row){

                $data = $row;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','supplier'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Supplier found'];
            return response()->json($response,200);
        }

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
        
       $this->validate($request,[
        
            'name' => 'required',
            'register_as'=>'required',
            'phone' => 'required',
           
          
        ]);
        //shopkeeper_id
        
      
        
        $phone_exist = User::where('phone', $request['phone'])->first();
        
        if(empty($phone_exist)){
            
            
        $store = Location::find(intval($request['id']));
        
        if(!empty($store)){
            
             $store_added = $store->added_by;
            //  dd($store_added);
        
        $user = User::create([
            'name' => $request['name'],
          
            // 'email' => $request['email'],
            
            'address' => $request['address'],
            'password' => Hash::make($request['phone']),
            'phone' => $request['phone'],
            'added_by' => $store_added,
            'store_id' => $store->id,
            'status' => 1,
        ]);
        
        $roles_added = Role::where('slug', 'Retail')->first();
        
        $roles_added2 = Role::where('slug', $request['register_as'])->first();
        
        $role_admin_id =  $roles_added->id;
        
        $role_user_id =  $roles_added2->id;
        
        
        $roles['user_id'] = $user->id;
        $roles['added_by'] = $store_added;
        $roles['role_id'] = $role_user_id;
        
        
         $roles['admin_role'] = $role_admin_id;
                          
        CompanyRoles::create($roles);

       

        $user->roles()->attach($role_user_id);
        
        $store->update(['shopkeeper_id' => $user->id]);
        
        
         $items5555 = array(
                        'manager' => $user->id,
                        'name' =>   $store->name,
                       'main' =>   $store->main,
                       'location_id'=>$store->id,
                         'order_no' => 0,
                        'added_by' => $added_by);
                       
                      $manager33333 = LocationManager::create($items5555);
        
        
        

        // $dt = $data->id;

        if(!empty($user)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $user->added_by,
                    'module_id'=>$user->id,
                     'module'=>'Shopkeeper',
                    'activity'=>"Shopkeeper " .  $user->name. "  Created",
                ]
                );                      
            }

        


        if($user)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Shopkeeper Created successful', 'Shopkeeper' => $user];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Shopkeeper Successfully'];
            return response()->json($response,200);
        }
        }
        else{
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Shopkeeper Cause of No Store found by that id Successfully'];
            return response()->json($response,200);
        }
        
        
        
        
        }
        else{
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Shopkeeper Cause of Phone Number Exists'];
            return response()->json($response,200);
        }
        
        
        
        
     
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
        
        $this->validate($request,[
            'name'=>'required',
           
        ]); 
        
        $data=Supplier::find($id);
        $data->name=$request->input('name');
        $data->address=$request->input('address');
        $data->phone=$request->input('phone');
        $data->TIN=$request->input('TIN');
        $data->email=$request->input('email');
        $data->user_id=$request->input('id');

        $seed =  $data->update();


        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->user_id,
                    'module_id'=>$data->id,
                     'module'=>'Supplier',
                    'activity'=>"Supplier " .  $data->name. "  Updated",
                ]
                );                      
            }

        


        if($seed)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Supplier Updated successful', 'supplier' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Supplier Successfully'];
            return response()->json($response,200);
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
        $data = Supplier::find($id);

         if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>   $data->user_id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $data->name. "  Deleted",
                        ]
                        );                      
       }

        $crop = $data->delete();

        if($crop)
        {
           
        
            $response=['success'=>true,'error'=>false,'message'=>'Supplier deleted'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Supplier'];
            return response()->json($response,200);
        }
    }
}
