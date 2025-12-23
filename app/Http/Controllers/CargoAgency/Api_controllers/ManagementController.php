<?php
namespace App\Http\Controllers\Api_controllers;

use App\Http\Controllers\Controller;
use App\Models\CarHistory;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPacel;
use App\Models\DriverRoute;
use App\Models\Management\Car;
use App\Models\Management\Driver;
use App\Models\PacelHistory;
use App\Models\PackageLoad;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\UserCarSelection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ManagementController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //homepage
    public function pacel(String $date)
    {
        //
        $pacels = CustomerPacel::whereDate('created_at', $date)->get();
        // $mizigo = $pacels->count();

       
        
        if($pacels->isEmpty()){

            $data['mizigo'] = 0;

            $data['jumla_gari'] = 0;

            $data['mizigo_gari'] = 0;

            $farmers = $data;

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];

            return response()->json($response,200);
                
        }
        else{

                $data['mizigo'] = CustomerPacel::whereDate('created_at', $date)->where('idadi_stoo', '!=', '0')->count();

                $jumla_gari = Car::whereDate('created_at', $date)->get();

                if($jumla_gari->isEmpty()){

                    $data['jumla_gari'] = 0;

                }
                else{

                    $data['jumla_gari'] = Car::whereDate('created_at', $date)->count();

                }

                $mizigo_gari = Car::where('status', 2)->whereDate('created_at', $date)->get();

                if($mizigo_gari->isEmpty()){

                    $data['mizigo_gari'] = 0;
                    
                }
                else{
                    $data['mizigo_gari'] = Car::where('status', 2)->whereDate('created_at', $date)->count();


                }


                $farmers = $data;
     
           

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
            return response()->json($response,200);
        } 
    }
    
    public function delete_car_route(String $date){

        $mizigo = Car::whereDate('created_at', '<=', $date)->get();

        // dd($mizigo);

        if($mizigo->isNotEmpty()){


            foreach($mizigo as $row){

            $data = $row->delete();


            }

            // foreach($mizigo as $row){

            // }

            $response=['success'=>true,'error'=>false,'message'=>'Deleted successfully'];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Cars found'];
            return response()->json($response,200);
        }
    }
    
    public function delete_driver_route(String $date){

        $mizigo = DriverRoute::whereDate('created_at', '<=', $date)->get();

        // dd($mizigo);

        if($mizigo->isNotEmpty()){


            foreach($mizigo as $row){

            $data = $row->delete();


            }

            // foreach($mizigo as $row){

            // }

            $response=['success'=>true,'error'=>false,'message'=>'Deleted successfully'];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Cars found'];
            return response()->json($response,200);
        }
    }

     public function delete_mizigo(String $date){

        $mizigo = CustomerPacel::whereDate('created_at', '<=', $date)->get();

        // dd($mizigo);

        if($mizigo->isNotEmpty()){


            foreach($mizigo as $row){

            $data = $row->delete();


            }

            // foreach($mizigo as $row){

            // }

            $response=['success'=>true,'error'=>false,'message'=>'Deleted successfully'];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Cars found'];
            return response()->json($response,200);
        }
    }

    public function delete_mizigo_history(String $date){

        $mizigo = PacelHistory::whereDate('created_at', '<=', $date)->get();

        if($mizigo->isNotEmpty()){

            foreach($mizigo as $row){
                $data = $row->delete();
            }

            $response=['success'=>true,'error'=>false,'message'=>'Deleted successfully'];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Cars found'];
            return response()->json($response,200);
        }
    }

    // public function test_unique_number(){
    //     $latestOrder = App\Order::orderBy('created_at','DESC')->first();
    //     $order->order_nr = '#'.str_pad($latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
    // }

    // mizigo according to date
    public function pacel_today()
    {
        //
        $today = Carbon::today();
        // $pacels = CustomerPacel::whereDate('created_at', $date)->get();
        // $pacels = CustomerPacel::where('idadi_stoo', '!=', '0')->get();

        // $data['mizigo_stoo'] = CustomerPacel::where('idadi_stoo', '!=', '0')->count();
        
        // $date = "2022-11-29";
        // $date = "2022-12-16";
        // $date = "2023-02-19";
         // $date = "2023-05-03";
        $date = "2023-07-09";
        // $pacels = CustomerPacel::whereDate('created_at', $date)->get();
        $pacels = CustomerPacel::where('idadi_stoo', '!=', '0')->whereDate('created_at', '>', $date)->get();

        $data['mizigo_stoo'] = CustomerPacel::where('idadi_stoo', '!=', '0')->whereDate('created_at', '<', $date)->count();

        // $mizigo = $pacels->count();

        if($pacels->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Pacels found on that date'];
            return response()->json($response,200);

            
        }
        
        else{

            foreach($pacels as $row){
                

                
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['idadi'] = $row->idadi;

                $data['delivery'] = $row->delivery;

                $data['bei'] = $row->bei;



                $data['idadi_stoo'] = $row->idadi_stoo;


                $data['mteja'] = $row->mteja;

                $data['mpokeaji'] = $row->mpokeaji;

                $data['hashtag'] = $row->hashtag;





                // $customer = Customer::where('id', $row->pacel_id)->get();

                // foreach($customer as $row2){

                $data['activity'] = $row->activity;

                // }

                $data['mzigo_unapotoka'] = $row->mzigo_unapotoka;
                $data['created_at'] = $row->created_at;
                $data['mzigo_unapokwenda'] = $row->mzigo_unapokwenda;
                $data['jumla'] = $row->jumla;
                $data['ela_iliyopokelewa'] = $row->ela_iliyopokelewa;


                $farmers[] = $data;
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
            return response()->json($response,200);
        }
    }

    //mizigo siku saba nyuma

    public function pacel_Date2(String $date)
    {
        //
        // $dt = Carbon::now();
        // $month2 = $dt->subDays(7);

       $xy = Carbon::createFromFormat('Y-m-d', $date)->subDays(7)->format('Y-m-d');

       

        $pacels = CustomerPacel::whereBetween('created_at', [$xy, $date])
                                ->where('idadi_stoo', '!=', '0')
                                ->orderBy('created_at', 'DESC')->get();

        
        // $pacels = CustomerPacel::all();

        // $mizigo = $pacels->count();

        if($pacels->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Pacels found on that date'];
            return response()->json($response,200);

            
        }
        
        else{

            foreach($pacels as $row){

                
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['idadi'] = $row->idadi;

                $data['delivery'] = $row->delivery;

                $data['bei'] = $row->bei;



                $data['idadi_stoo'] = $row->idadi_stoo;


                $data['mteja'] = $row->mteja;

                $data['mpokeaji'] = $row->mpokeaji;

                $data['hashtag'] = $row->hashtag;





                // $customer = Customer::where('id', $row->pacel_id)->get();

                // foreach($customer as $row2){

                $data['activity'] = $row->activity;

                // }

                $data['mzigo_unapotoka'] = $row->mzigo_unapotoka;
                $data['created_at'] = $row->created_at;
                $data['mzigo_unapokwenda'] = $row->mzigo_unapokwenda;
                $data['jumla'] = $row->jumla;
                $data['ela_iliyopokelewa'] = $row->ela_iliyopokelewa;


                $farmers[] = $data;
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
            return response()->json($response,200);
        }
    }

    //car zilizopakia mtu according to tarehe
    public function car_today(int $id, String $date)
    {
        //
        // $today = Carbon::today();
        $carSelected = DriverRoute::join('users', 'users.id', '=', 'driver_routes.user_id' )
                    ->join('cars', 'cars.id', '=', 'driver_routes.car_id' )
                    ->whereIn('cars.status', ['1','2','4'])
                    ->where('users.id', $id)->whereDate('driver_routes.created_at', '<=' ,$date)
                    ->get();
        
        // $pacels = Car::where()->whereDate('created_at', $date)->get();
        // $mizigo = $pacels->count();

        if($carSelected->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Cars found with that user id'];
            return response()->json($response,200);

            
        }
        
        else{

            foreach($carSelected as $row){

                $car = Car::find($row->car_id);
             
                $data['carNumber'] = $car->carNumber;
                $data['id'] = intval($car->id);
                $driver = Driver::where('id', $car->driver_id)->value('name');
                $data['from'] = $row->from;

                $data['to'] = $row->to;

                $data['driver_id'] = intval($car->driver_id);

                $data['driver'] = $driver;


                $farmers = $data;
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','car'=>$farmers];
            return response()->json($response,200);
        }
    }


    // 
    public function driver(String $date)
    {
        //
        $drivers = Driver::where('status', '1')->get();
        // $mizigo = $pacels->count();

       
        
        if($drivers->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No driver found'];
            return response()->json($response,200);

            
        }
        else{

            foreach($drivers as $row){

                $data['id'] = $row->id;
                

                $data['name'] = $row->name;
                $phone = $row->phone;
                if(empty($phone)){

                    $data['phone'] = "no phone registerd";

                }
                else{

                    $data['phone'] = $row->phone;

 
                }

                if( $row->status == '2'){

                $data['status'] = "Assigned";

                }
                elseif( $row->status == '1'){

                $data['status'] = "Not Assigned";

                }
                else{

                    $data['status'] = "Start offload";
    
                    }

                if ($row->assigned_date == $date) {
                        $data['assigned'] = "true";
                    }

                else{
                     
                        $data['assigned'] = "false";
                        
                    }    

                
                
                

                $farmers[] = $data;
        
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','drivers'=>$farmers];
            return response()->json($response,200);

            
        } 
    }

    public function car()
    {
        //
        $cars = Car::all();
        // $mizigo = $pacels->count();

       
        
        if($cars->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Cars found'];
            return response()->json($response,200);

            
        }
        else{

            foreach($cars as $row){

                $data['id'] = $row->id;


                $data['carNumber'] = $row->carNumber;
                //driver_id

                $driver_id = $row->driver_id;
                if(empty($driver_id)){
                    $data['driver_id'] = null;

                    $data['driver'] = 'null';

                    $data['from'] = null;

                    $data['to'] = null;

                    $data['start_date'] = null;

                }
                else{
                    $driver =  Driver::find($driver_id);

                    $data['driver_id'] = intval($driver->id);

                    
                    $data['driver'] = $driver->name;

                    $driverRoute = DriverRoute::where('car_id', $row->id)->where('driver_id', $row->driver_id)->orderBy('created_at', 'DESC')->first();
                    
                    // dd($row->id);

                    if($row->status == '2'){

                        $data['from'] = $driverRoute->from;

                        $data['to'] = $driverRoute->to;

                        $data['start_date'] = $driverRoute->start_date;

                    // }
                    // elseif($row->status == '3'){

                    //     $data['from'] = $driverRoute->from;

                    //     $data['to'] = $driverRoute->to;
                    // }
                    // elseif($row->status == '4'){

                    //     $data['from'] = $driverRoute->from;

                    //     $data['to'] = $driverRoute->to;
                    }
                    else{

                        $data['from'] = null;

                        $data['to'] = null;

                        $data['start_date'] = null;


                    }
                    
                    

                }


                if( $row->status == '1'){

                $data['status'] = "inasubiri";

                }
                elseif( $row->status == '2'){

                $data['status'] = "inapakiwa";

                }
                elseif( $row->status == '3'){

                    $data['status'] = "imefungwa";
    
                    }
                else{

                    $data['status'] = "kushusha";
    
                    }

                $farmers[] = $data;
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','cars'=>$farmers];
            return response()->json($response,200);

            
        } 
    }
    
    public function car_today_test($id){

        $carNumber = Car::find(intval($id))->carNumber;
        
        $carId = $id;

        $dataResult = DriverRoute::where('car_id', $id)->groupBy(DB::RAW('DATE(start_date)'))->groupBy(DB::RAW('DATE(closeDate)'))->orderBy('created_at', 'ASC')->get();

        if($dataResult->isNotEmpty()){

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$dataResult];
            return response()->json($response,200);
            
        }
        else{
            $response=['success'=>false,'error'=>true,'message'=>'No Pacel in that car found'];
            return response()->json($response,200);
        }
        // return view('management.car_today_routes', compact('carNumber', 'dataResult'));
    }

    public function packing_pacel_date(int $id){

        // $pacels = PacelHistory::where('car_id'. $id)
        //             ->groupBy('created_at')
        //             ->orderBy('created_at', 'DESC')
        //             ->get(array(
        //                 DB::raw('Date(created_at) as date'),
        //                 DB::raw('COUNT(*) as "views"')
        //             ));
       
         
        
        $pacels = PacelHistory::where('car_id',$id)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
         });

         

        if($pacels->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Pacel in that car found'];
            return response()->json($response,200);

            
        }
        else{

            foreach($pacels as $key => $pacel){
                $data['day'] = $key;
                // $data['totalCount'] = $pacel->count();
                $data['totalPacel'] = $pacel->sum('idadi');

                $farmers[] = $data;

            }

            

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
            return response()->json($response,200);
            
        } 

        // foreach($pacels as $row){

        //     $data['date'] = $row->created_at;
            
        // }

    }

    //returns mizigo iliyopakiwa kwenye gari according to date
    public function packing_pacel(int $id , String  $date, String $key){

        if($key == "Manifest"){

            
            
            $pacels = PacelHistory::where('car_id', $id)->whereDate('created_at',$date)->get();
            // ->orderBy('pacel_id', 'DESC')
            // ->groupBy('added_by', 'pacel_id');
            // ->groupBy(function($item) {
            //     return $item->added_by;
            //  });

            $pacelUnique =  PacelHistory::where('car_id', $id)
            ->whereDate('created_at',$date)
            ->where('idadi_kupakia', '!=', '0')
            ->orderBy('pacel_id', 'DESC')
            ->distinct()
            ->get(['pacel_id']);

            // dd($)

            
    
            if($pacels->isEmpty()){
    
                $response=['success'=>false,'error'=>true,'message'=>'No Pacel in that car found'];
                return response()->json($response,200);
    
            //    
            }
            else{
        

            foreach($pacelUnique as $it){

                $delivery = CustomerPacel::where('id', $it->pacel_id)->value('delivery');

                $mteja = CustomerPacel::where('id', $it->pacel_id)->value('mteja');

                $mpokeaji = CustomerPacel::where('id', $it->pacel_id)->value('mpokeaji');

                $name = CustomerPacel::where('id', $it->pacel_id)->value('name');



                $idadi = CustomerPacel::where('id', $it->pacel_id)->value('idadi');

                $idadi_stoo = CustomerPacel::where('id', $it->pacel_id)->value('idadi_stoo');


                $created_at = CustomerPacel::where('id', $it->pacel_id)->value('created_at');

                $mzigo_unapotoka = CustomerPacel::where('id', $it->pacel_id)->value('mzigo_unapotoka');

                $mzigo_unapokwenda = CustomerPacel::where('id', $it->pacel_id)->value('mzigo_unapokwenda');
               
                     $carP = Car::find($id);

                     if(!empty($carP)){
     
                         $data['car_id'] = $carP->id;
         
                         $data['carNumber'] = $carP->carNumber;
                     }
                     else{
     
                         $data['car_id'] = null;
         
                         $data['carNumber'] = null;
                     }

                    $data['id'] = intval($it->pacel_id);
                    $data['mteja'] = $mteja;
                    $data['mpokeaji'] = $mpokeaji;
                    $data['name'] = $name;


                    $driver_id = DriverRoute::where('car_id', $id)->whereDate('created_at', $date)->value('driver_id');

                    $data['driver'] = Driver::where('id', $driver_id)->value('name');

                    $data['mzigo_unapotoka'] = $mzigo_unapotoka;
                    $data['mzigo_unapokwenda'] = $mzigo_unapokwenda;



                    $data['delivery'] = $delivery;

                    $data['idadi'] = $idadi;
    
    
                    $data['idadi_stoo'] = $idadi_stoo;


                    $data['created_at'] = $created_at;

                    $history = [];

                 $histories = PacelHistory::where('pacel_id',$it->pacel_id)->where('car_id', $id)->whereDate('created_at',$date)->where('activity', 'kupakia')->get();

                 foreach($histories as $row){

                    // if( $row->activity == "kupakia"){

                        $data2['idadi_kupakia'] = $row->idadi_kupakia;
                        $data2['idadi_shusha'] = $row->idadi_shusha;
                        $data2['hashtag'] = $row->hashtag;
                        $data2['bei'] = $row->bei;
                        $data2['ela_iliyopokelewa'] = $row->ela_iliyopokelewa;
                        $data2['jumla'] = $row->jumla;
                        $data2['activity'] = $row->activity;

                    
            
                        $user = User::where('id', $row->added_by)->first();
                        $data2['mwandishi'] = $user->name;
            
                        
                        // $created_at = CustomerPacel::where('id', $row->pacel_id)->value('created_at');

                        $data2['created_at'] = $row->created_at;

                        $data2['pacel_hist_id'] = $row->id;

                        
                        $history[] = $data2;


                    // }

                        

                 }

                 $data['history'] = $history;


                 $items[] = $data;


            }
    
                $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$items];
                return response()->json($response,200);
                
            } 
        }
        else{


            $pacels = PacelHistory::where('car_id', $id)->whereDate('created_at', $date)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy(function ($item) {
                return $item->added_by;
            });



            if ($pacels->isEmpty()) {
                $response=['success'=>false,'error'=>true,'message'=>'No Pacel in that car found'];
                return response()->json($response, 200);
            } else {
                foreach ($pacels as $key => $pacel) {
                    // $data = $pacel;


                    $data['user_id'] = $key;

                    foreach ($pacel as $row) {
                        $data = $row;

                        $carP = Car::find($row->car_id);

                        if(!empty($carP)){

                            $data['car_id'] = intval($carP->id);
            
                            $data['carNumber'] = $carP->carNumber;
                        }
                        else{

                            $data['car_id'] = null;
            
                            $data['carNumber'] = null;
                        }

                        $data['user_id'] = $key;

                        $data['mteja'] = $row->mteja;
                        $data['id'] = $row->pacel_id;
                        $data['delivery'] = $row->delivery;


                        $data['mpokeaji'] = $row->mpokeaji;
                        $data['hashtag'] = $row->hashtag;

                        $user = User::where('id', $row->added_by)->first();
                        $data['mwandishi'] = $user->name;
                        // $data['activity'] = $row->activity;
                        $idadi = CustomerPacel::where('id', $row->pacel_id)->value('idadi');
                        $data['idadi'] = $idadi;

                        $idadi_stoo = CustomerPacel::where('id', $row->pacel_id)->value('idadi_stoo');

                        $data['idadi_stoo'] = $idadi_stoo;



                        // $data['idadi_kupakia'] =  PacelHistory::where('car_id', $id)->whereDate('created_at',$date)->where('pacel_id', $row->pacel_id)->where('added_by', $row->added_by)->sum('idadi_kupakia');


                        // $data['idadi_shusha'] = PacelHistory::where('car_id', $id)->whereDate('created_at',$date)->where('pacel_id', $row->pacel_id)->where('added_by', $row->added_by)->sum('idadi_shusha');


                        $data['idadi_kupakia'] =  $row->idadi_kupakia;


                        $data['idadi_shusha'] = $row->idadi_shusha;

                     

                        $userPacels[]=$data;
                    }

                    $staffData["mwandishi"]=$key;
                    $staffData["pacels"]=$userPacels;
                    $farmers[] = $staffData;
                }

                $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
                return response()->json($response, 200);
    }

        }
       

    }
    
 
    public function store_pacel(Request $request)
    {
        //

        $this->validate($request,[
            'name'=>'required',
            'mteja'=>'required',
            'mpokeaji'=>'required',
            'idadi'=>'required',
            'id'=>'required',
            
        ]); 
        
        // dd($request->input('mpokeaji'));
        
        $usr = User::find($request->input('id'));
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
            $activity = "kusajiliwa";

            $data['mteja'] = $request->input('mteja');
            $data['mpokeaji'] = $request->input('mpokeaji');
            $data['added_by'] = $request->input('id');
            $customer = Customer::create($data);
            
            
     

                    $items = array(
                        'mteja' => $request->input('mteja'),
                        'mpokeaji' => $request->input('mpokeaji'),
                        'activity' => $activity,
                        'name' => $request->input('name'),
                        'idadi' => $request->input('idadi'),
                        'idadi_stoo' => $request->input('idadi'),
                        'bei' => $request->input('bei'),
                        'receipt' =>$request->input('receipt'),
                        'mzigo_unapotoka' =>   $request->input('mzigo_unapotoka'),
                        'mzigo_unapokwenda' =>  $request->input('mzigo_unapokwenda'),
                         'jumla' => $request->input('jumla'),
                         'customer_id' => $customer->id,
                           'ela_iliyopokelewa' =>  $request->input('ela_iliyopokelewa'),
                           'added_by' => $request->input('id'));
                       
                        $cp   =   CustomerPacel::create($items);

                     
                    PacelHistory::create([
                        'pacel_id' => $cp->id,
                        'mteja' => $request->input('mteja'),
                        'mpokeaji' => $request->input('mpokeaji'),
                        'activity' => $activity,
                        'name' => $request->input('name'),
                        'idadi' => $request->input('idadi'),
                        'idadi_stoo' => $request->input('idadi'),
                        'receipt' =>$request->input('receipt'),
                        'bei' => $request->input('bei'),
                        'mzigo_unapotoka' =>   $request->input('mzigo_unapotoka'),
                        'mzigo_unapokwenda' =>  $request->input('mzigo_unapokwenda'),
                        'jumla' => $request->input('jumla'),
                        'ela_iliyopokelewa' =>  $request->input('ela_iliyopokelewa'),
                        'added_by' => $request->input('id')
                       
                        ]);  


                        $count = $this->generateUniqueCode();

                        $delivery = $count.$cp->id."-".$request->input('id');

                        // dd($delivery);

                        CustomerPacel::where('id', $cp->id)->update(['delivery' => $delivery]);

                        PacelHistory::where('pacel_id', $cp->id)->update(['delivery' => $delivery]);
    
         
    
         
    
    
            if($cp)
            {

                $response=['success'=>true,'error'=>false, 'message' => 'Pacel  Created successful', 'pacel' => $cp];
                return response()->json($response, 200);
            }
            else
            {
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Pacel Successfully'];
                return response()->json($response,200);
            }
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }
    
    
    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (CustomerPacel::where("delivery", "=", $code)->first());
  
        return $code;
    }



    public function pacel_history(int $id){

        $pacels = PacelHistory::where('pacel_id', $id)->get();

        if($pacels->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Pacel in that car found'];
            return response()->json($response,200);

           
        }

        else{

            foreach($pacels as $row){
                $carP = Car::find($row->car_id);

                if(!empty($carP)){

                    $data['car_id'] = $carP->id;
    
                    $data['carNumber'] = $carP->carNumber;
                }
                else{

                    $data['car_id'] = null;
    
                    $data['carNumber'] = null;
                }

                

                $user = User::where('id', $row->added_by)->first();
                $data['mwandishi'] = $user->name;
                $data['activity'] = $row->activity;

                $data['delivery'] = $row->delivery;

                $data['idadi'] = $row->idadi;

                $data['hashtag'] = $row->hashtag;


                $data['bei'] = $row->bei;



                $createdAt = Carbon::parse($row->created_at);

                $data['time'] = $createdAt->toTimeString();

                $farmers[] = $data;

            }

            

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
            return response()->json($response,200);
        }
    }

    public function delivery_search(String $delivery){

        $pacels = CustomerPacel::where('delivery', $delivery)->get();
        // $mizigo = $pacels->count();

        if($pacels->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Pacels found by that delivery number'];
            return response()->json($response,200);

            
        }
        
        else{

            foreach($pacels as $row){

                
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['idadi'] = $row->idadi;

                $data['idadi_stoo'] = $row->idadi_stoo;


                $data['mteja'] = $row->mteja;

                $data['mpokeaji'] = $row->mpokeaji;

                $data['hashtag'] = $row->hashtag;

                $data['delivery'] = $row->delivery;

                $data['bei'] = $row->bei;




                // $customer = Customer::where('id', $row->pacel_id)->get();

                // foreach($customer as $row2){

                $data['activity'] = $row->activity;

                // }

                $data['mzigo_unapotoka'] = $row->mzigo_unapotoka;
                $data['created_at'] = $row->created_at;
                $data['mzigo_unapokwenda'] = $row->mzigo_unapokwenda;
                $data['jumla'] = $row->jumla;
                $data['ela_iliyopokelewa'] = $row->ela_iliyopokelewa;


                $farmers[] = $data;
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','pacels'=>$farmers];
            return response()->json($response,200);
        }

    }


    public function money_recieved_car(int $id, String $date){
        $total = PacelHistory::where('car_id', $id)->whereDate('created_at', $date)
                               ->where('activity','kupakia')
                               ->where('idadi_kupakia', '!=', '0')->sum('jumla');
   
        if($total){

            $total_format = number_format($total,2);

            $response=['success'=>true,'error'=>false,'message'=>'successfully','total'=>$total_format];
            return response()->json($response,200);
        }
        else{
            $total_format = number_format('0',2);

            $response=['success'=>true,'error'=>false,'message'=>'No Pacels found by that delivery number', 'total' => $total_format];
            return response()->json($response,200);
        }
    }

    public function arrived_car_date(String $date){

        $carsDate =  DriverRoute::whereDate('created_at',$date)
                                    ->get()
                                    ->unique('car_id');
                                    
                                    
                                    
                                    // ->where('status', '!=', '2')

        if($carsDate->isEmpty()){

            $response=['success'=>false,'error'=>true,'message'=>'No Car found by that date'];
            return response()->json($response,200);
                        
                                    
        }
        else{
            
            foreach($carsDate as $row){

                
                // $data  = $row;

                $car_id = $row->car_id;

                if(empty($car_id)){

                    $data['carNumber'] = 'null';
                    
                }
                else{
                    $data['carNumber'] = Car::where('id', $car_id)->value('carNumber');
                }

                $data['id'] = intval($row->car_id);

                // $data['closeDate'] = $row->driver_id;



                // $data['carNumber'] = $row->carNumber;
                //driver_id
                // $driver =  DriverRoute::where('car_id', $car_id)->where('');


                $driver_id = $row->driver_id;
                if(empty($driver_id)){
                    // $data['driver'] = 'null';

                    $data['driver_id'] = null;

                    $data['driver'] = 'null';

                    $data['from'] = null;

                    $data['to'] = null;

                    $data['start_date'] = null;

                }
                else{
                    $driver =  Driver::find($driver_id);

                    $data['driver_id'] = intval($driver->id);

                    $data['driver'] = $driver->name;

                    // $driverRoute = DriverRoute::where('car_id', $row->car_id)->where('driver_id', $row->driver_id)->orderBy('created_at', 'DESC')->first();

                    // if($row->status == '2'){

                        $data['from'] = $row->from;

                        $data['to'] = $row->to;
                   
                        $data['start_date'] = $row->start_date;

                    

                }


                if( $row->status == '1'){

                $data['status'] = "inasubiri";

                }
                elseif( $row->status == '2'){

                $data['status'] = "inapakiwa";

                }
                elseif( $row->status == '3'){

                    $data['status'] = "imefungwa";
    
                }
                else{

                    $data['status'] = "null";
    
                }




                $farmers[] = $data;
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','carsDate'=>$farmers];
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
        //
    }

    //kufunga gari baada ya kupakia
    public function car_close(int $id){


    $today = Carbon::now()->format('Y-m-d');
    $car =  Car::where('id', $id)->update(['status' => '3', 'closeDate' => $today]);

    // $car_history =  DriverRoute::where('car_id', $id)->latest()->first()->update(['status' => '3', 'closeDate' => $today]);
    $car_history =  DriverRoute::where('car_id', $id)->latest()->first();


    if(!empty($car_history)){

        $car_to_closed = DriverRoute::where('car_id', $car_history->car_id)->where('driver_id', $car_history->driver_id)->whereDate('start_date', $car_history->start_date)->where('from', $car_history->from)->where('to', $car_history->to)->get();

        foreach($car_to_closed as $row){

            $car_upt = $row->update(['status' => '3', 'closeDate' => $today]);
        }
    }
    // else{

    // }


    // $car_history =  CarHistory::where('id', $request->input('car_id'))->update(['driver_id' => $request->input('driver_id'), 'status' => '2']);


    if($car){

        $response=['success'=>true,'error'=>false,'message'=>'successfully','car'=>$car];
        return response()->json($response,200);

       
    }
    else{
        $response=['success'=>false,'error'=>true,'message'=> 'Car Not closed'];
        return response()->json($response,200);

    }
    }

    public function driver_store(Request $request)
    {
        
        $this->validate($request,[
            'name'=>'required',

        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        $farmer= new Driver();

        $farmer->name=$request->input('name');
        $farmer->phone=$request->input('phone');
        // $farmer->assigned_date = Carbon::now()->format('Y-m-d');
        $farmer->status = 1;
        $farmer->save();
        if($farmer)
        {
            $response=['success'=>true,'error'=>false,'message'=>'New Driver registered successful'];
            return response()->json($response,200);
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new Driver'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
    }

    public function car_store(Request $request)
    {
        
        $this->validate($request,[
            'carNumber'=>'required',

        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        $farmer= new Car();

        $farmer->carNumber=$request->input('carNumber');
        $farmer->status = 1;
        $farmer->save();
        if($farmer)
        {
            $response=['success'=>true,'error'=>false,'message'=>'New Car registered successful'];
            return response()->json($response,200);
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to register new  Car'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
    }

    public function car_selection(Request $request)
    {
        
        $this->validate($request,[
            'user_id'=>'required',
            'car_id'=>'required',
            'driver_id'=>'required',
            'from'=>'required',
            'to'=>'required',

        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);

        $assigned_date = Carbon::now()->format('Y-m-d');


        $driver =  Driver::where('id', $request->input('driver_id'))->update(['status' => '2', 'assigned_date' => $assigned_date]);

        $car =  Car::where('id', $request->input('car_id'))->update(['driver_id' => $request->input('driver_id'), 'status' => '2']);

      
        $farmer= new DriverRoute();

        if(!empty($request->start_date)){

            $farmer->user_id=$request->input('user_id');
            $farmer->car_id=$request->input('car_id');
            $farmer->driver_id=$request->input('driver_id');
            $farmer->from=$request->input('from');
            $farmer->to=$request->input('to');
            $farmer->status= '2';
            $farmer->start_date=$request->input('start_date');

            $farmer->save();

        }
        else{

            $today = Carbon::now()->format('Y-m-d');


            $farmer->user_id=$request->input('user_id');
            $farmer->car_id=$request->input('car_id');
            $farmer->driver_id=$request->input('driver_id');
            $farmer->from=$request->input('from');
            $farmer->to=$request->input('to');
            $farmer->status= '2';
            $farmer->start_date = $today;


            $farmer->save();

        }
        



        // $car_history = new CarHistory();

        // $car_history->user_id=$request->input('user_id');
        // $car_history->car_id=$request->input('car_id');
        // $car_history->driver_id=$request->input('driver_id');
        // $car_history->status= '2';
        // $car_history->startPacking= $assigned_date;

        // $car_history->save();

        if($farmer)
        {
            $response=['success'=>true,'error'=>false,'message'=>'New Car and Driver  selected and Route given  successful', 'farmer' => $farmer];
            return response()->json($response,200);
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to select Car and Driver successful'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
    }

    public function packing_store(Request $request)
    {
        
        $this->validate($request,[
            'user_id'=>'required',
            'car_id'=>'required',
            'pacel_id'=>'required',
            'idadi'=>'required',
            'price'=>'required',
            'activity'=>'required',



        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        $farmer= new PackageLoad();

        $farmer->user_id=$request->input('user_id');
        $farmer->car_id=$request->input('car_id');
        $farmer->pacel_id=$request->input('pacel_id');
        $farmer->idadi=$request->input('idadi');
        $farmer->price=$request->input('price');
        $farmer->save();

        //update on customer pacel table

        $pacelOld =  CustomerPacel::find($request->pacel_id);

        // $pacelOld->idadi_stoo = $pacelOld->idadi;
        if($request->input('activity') == "kupakia"){

            $pacelOld->activity = $request->input('activity');

            $pacelOld->idadi_kupakia =$pacelOld->idadi_kupakia + $request->input('idadi');


            $pacelOld->idadi_stoo = $pacelOld->idadi_stoo  - $request->input('idadi');


            $pacelOld->bei = $request->input('price');

            $pacelOld->hashtag = $request->input('hashtag');


        

        $pacelOld->car_id = $request->input('car_id');

        // $pacelOld->driver_id = $request->input('driver_id');

        $pacelOld->jumla = $request->input('idadi') * $request->input('price');

        $pacelOld->update();

        //install on pacel 

        $cp_id = CustomerPacel::find($request->pacel_id);


        $pacelChange = PacelHistory::where('pacel_id', $request->input('pacel_id'))->where('car_id', $request->input('car_id'))
                                    ->where('hashtag', $request->input('hashtag'))->where('bei', $request->input('price'))->first();
            

        if($pacelChange){

            // update mzigo wkt wa kupakia
            $pacel = PacelHistory::find($pacelChange->id);

            // $pacel231->bei = $pacel231->idadi_kupakia + $request->input('price');

            // $pacel231->hashtag = $pacel231->idadi_kupakia + $request->input('hashtag');

            // $pacel->idadi_kupakia = $pacelChange->idadi_kupakia + $request->input('idadi');

            // $idadi_kupakia = $pacelChange->idadi_kupakia + $request->input('idadi');


            // $pacel->jumla = $pacelChange->bei * $idadi_kupakia;

            $data['idadi_kupakia'] = $pacelChange->idadi_kupakia + $request->input('idadi');

            $idadi_kupakia = $pacelChange->idadi_kupakia + $request->input('idadi');


            $data['jumla'] = $pacelChange->bei * $idadi_kupakia;

            $pacel->update($data);
               

        }
        else{


            $pacel = new  PacelHistory();


            $pacel->pacel_id = $cp_id->id;

            $pacel->mteja = $cp_id->mteja;

            $pacel->mpokeaji = $cp_id->mpokeaji;

            $pacel->name = $cp_id->name;

            $pacel->idadi = $request->input('idadi');

            $pacel->bei = $request->input('price');

            $pacel->hashtag = $request->input('hashtag');


            $pacel->ela_iliyopokelewa = $cp_id->ela_iliyopokelewa;

            $pacel->jumla = $request->input('idadi') * $request->input('price');

            $pacel->activity = $request->input('activity');

            $pacel->mzigo_unapotoka = $cp_id->mzigo_unapotoka;

            $pacel->mzigo_unapokwenda = $cp_id->mzigo_unapokwenda;

            $pacel->car_id = $request->input('car_id');

            $pacel->customer_id = $cp_id->customer_id;

            $pacel->driver_id = $request->input('driver_id');

            $pacel->idadi_kupakia = $request->input('idadi');

            // $pacel->idadi_shusha = $cp_id->idadi_shusha;

            $pacel->delivery = $cp_id->delivery;

            $pacel->status = $cp_id->status;

            $pacel->added_by = $request->input('user_id');

            $pacel->save();

           

        }
        

        }
        elseif($request->input('activity') == "kubadili"){

        $pacelOld->activity = $request->input('activity');

        // $pacelOld->idadi_kupakia =$pacelOld->idadi_kupakia +;


        // $pacelOld->idadi_stoo = $pacelOld->idadi_stoo  - $request->input('idadi');


        $pacelOld->bei = $request->input('price');

        $pacelOld->hashtag = $request->input('hashtag');


        

        // $pacelOld->car_id = $request->input('car_id');

        // $pacelOld->driver_id = $request->input('driver_id');

        $pacelOld->jumla = $pacelOld->idadi_stoo * $request->input('price');

        $pacelOld->update();

        //install on pacel 

        $cp_id = CustomerPacel::find($request->pacel_id);


        $pacel = new  PacelHistory();


        $pacel->pacel_id = $cp_id->id;

        $pacel->mteja = $cp_id->mteja;

        $pacel->mpokeaji = $cp_id->mpokeaji;

        $pacel->name = $cp_id->name;

        $pacel->idadi = $cp_id->idadi; 

        $pacel->bei = $request->input('price');

        $pacel->hashtag = $request->input('hashtag');


        $pacel->ela_iliyopokelewa = $cp_id->ela_iliyopokelewa;

        $pacel->jumla = $cp_id->idadi * $request->input('price');

        $pacel->activity = $request->input('activity');

        $pacel->mzigo_unapotoka = $cp_id->mzigo_unapotoka;

        $pacel->mzigo_unapokwenda = $cp_id->mzigo_unapokwenda;

        $pacel->car_id = $cp_id->car_id;

        $pacel->customer_id = $cp_id->customer_id;

        $pacel->driver_id = $request->input('driver_id');

        // $pacel->idadi_kupakia = $cp_id->idadi_kupakia;

        // $pacel->idadi_shusha = $cp_id->idadi_shusha;

        $pacel->delivery = $cp_id->delivery;

        $pacel->status = $cp_id->status;

        $pacel->added_by = $request->input('user_id');

        $pacel->save();

        // update mzigo
        $pacel23 = PacelHistory::find($request->input('pacel_hist_id'));

        $data23['bei'] = $request->input('price');

        $data23['hashtag'] = $request->input('hashtag');

        $data23['jumla'] = $pacel23->idadi_kupakia * $request->input('price');

        $pacel23->update($data23);





        }
        else{

        $pacelOld->idadi_shusha = $pacelOld->idadi_shusha + $request->input('idadi');

        $pacelOld->idadi_kupakia = $pacelOld->idadi_kupakia - $request->input('idadi');


        $pacelOld->bei = $request->input('price');

        $pacelOld->hashtag = $request->input('hashtag');


        $pacelOld->activity = $request->input('activity');

        $pacelOld->idadi_stoo = $pacelOld->idadi_stoo  +  $request->input('idadi');


        $pacelOld->car_id = $request->input('car_id');

        // $pacelOld->driver_id = $request->input('driver_id');

        $pacelOld->jumla = $request->input('idadi') * $request->input('price');

        $pacelOld->update();

         //install on pacel 

         $cp_id = CustomerPacel::find($request->pacel_id);


         $pacel = new  PacelHistory();
 
 
         $pacel->pacel_id = $cp_id->id;
 
         $pacel->mteja = $cp_id->mteja;
 
         $pacel->mpokeaji = $cp_id->mpokeaji;
 
         $pacel->name = $cp_id->name;
 
         $pacel->idadi = $cp_id->idadi;
 
         $pacel->bei = $request->input('price');

         $pacel->hashtag = $request->input('hashtag');

 
         $pacel->ela_iliyopokelewa = $cp_id->ela_iliyopokelewa;
 
         $pacel->jumla = $cp_id->jumla;
 
         $pacel->activity = $request->input('activity');
 
         $pacel->mzigo_unapotoka = $cp_id->mzigo_unapotoka;
 
         $pacel->mzigo_unapokwenda = $cp_id->mzigo_unapokwenda;
 
         $pacel->car_id = $request->input('car_id');
 
         $pacel->customer_id = $cp_id->customer_id;
 
         $pacel->driver_id = $request->input('driver_id');
 
        //  $pacel->idadi_kupakia = $cp_id->idadi_kupakia;
 
         $pacel->idadi_shusha = $request->input('idadi');
 
         $pacel->delivery = $cp_id->delivery;
 
         $pacel->status = $cp_id->status;
 
         $pacel->added_by = $request->input('user_id');

 
         $pacel->save();

         // update mzigo wkt kushusha
        $pacel23 = PacelHistory::find($request->input('pacel_hist_id'));

        // $pacel23->bei = $request->input('price');

        // $pacel23->hashtag = $request->input('hashtag');
        $idadi_kupakia2 = $pacel23->idadi_kupakia - $request->input('idadi');

        $data123['idadi_kupakia'] = $pacel23->idadi_kupakia - $request->input('idadi');

        $data123['jumla'] = $request->input('price') * $idadi_kupakia2;

        $pacel23->update($data123);

        }

        

        if($pacel)
        {
            $response=['success'=>true,'error'=>false,'message'=>'Package packing  successful', 'pacel'=>$pacel];
            return response()->json($response,200);
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to pack Package successful'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
    }

    public function unpacking_store(Request $request)
    {
        
        $this->validate($request,[
            'user_id'=>'required',
            'car_id'=>'required',
            'pacel_id'=>'required',
            'idadi'=>'required',
            'price'=>'required'


        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        // $farmer= new PackageLoad();

        // $farmer->user_id=$request->input('user_id');
        // $farmer->car_id=$request->input('car_id');
        // $farmer->pacel_id=$request->input('pacel_id');
        // $farmer->idadi=$request->input('idadi');
        // $farmer->price=$request->input('price');
        // $farmer->save();

        //update on customer pacel table

        $pacelOld =  CustomerPacel::find($request->pacel_id);


        $pacelOld->idadi_shusha = $pacelOld->idadi_shusha + $request->input('idadi');

        $pacelOld->idadi_kupakia = $pacelOld->idadi_kupakia - $request->input('idadi');


        $pacelOld->bei = $request->input('price');

        $pacelOld->activity = $request->input('activity');

        $pacelOld->idadi_stoo = $pacelOld->idadi_stoo  +  $request->input('idadi');


        $pacelOld->car_id = $request->input('car_id');

        // $pacelOld->driver_id = $request->input('driver_id');

        $pacelOld->jumla = $request->input('idadi') * $request->input('price');

        $pacelOld->update();

        //install on pacel 

        $pacel = new  PacelHistory();

        $pacel = $pacelOld;

        // $pacel->bei = $request->input('price');

        // $pacel->idadi_stoo = $pacelOld->idadi + $request->input('idadi');


        // $pacel->activity = $request->input('activity');

        // $pacel->car_id = $request->input('car_id');

        $pacel->save();

        if($pacelOld)
        {
            $response=['success'=>true,'error'=>false,'message'=>'Package packing  successful', 'pacel'=>$pacelOld];
            return response()->json($response,200);
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to pack Package successful'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
    }

    

    public function driver_assign(int $driver_id, int $car_id)
    {
        
      
        // $assigned_date = Carbon::now()->format('Y-m-d');

        $driver =  Driver::where('id', $driver_id)->update(['status' => '2']);

        $car =  Car::where('id', $car_id)->update(['driver_id' => $driver_id]);

        if($driver)
        {
            if($car){
                $response=['success'=>true,'error'=>false,'message'=>'Driver Assigned car successful'];
                return response()->json($response,200);
            }
            else{
                $response=['success'=>false,'error'=>true,'message'=>'Car Failed to be Assigned successful cause of car id'];
                return response()->json($response,200);
            }
            
        }
        else
        {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Driver Assigned Car'];
            return response()->json($response,200);
        }

        //return view('manage-farmer');
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
    }
}
