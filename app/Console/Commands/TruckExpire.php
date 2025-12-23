<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Truck;
use App\Models\TruckInsurance;
use App\Models\Sticker;
use App\Models\RoadPermit;
use App\Models\Comesa;
use App\Models\WMA;
use App\Models\Device;
use App\Models\TruckCarbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Notification;

class TruckExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truck:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire truck license sms before number of days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
      
        $date = today()->addMonths(2)->format('Y-m-d');
         $admin=User::where('id',auth()->user()->added_by)->first();
         $user=auth()->user()->added_by;
         
          //sticker
          $sq = "SELECT trucks.id,trucks.truck_name,trucks.reg_no,MAX(stickers.expire_date) AS expire_date FROM stickers 
          LEFT JOIN trucks ON stickers.truck_id =trucks.id WHERE stickers.expire_date < '".$date."' AND stickers.added_by='".$user."' GROUP BY stickers.truck_id";
          $sd =  DB::select($sq);
        
        if(count($sd) > 0){
            
        foreach($sd as $row){
            
              $due_date=date('d/m/Y', strtotime($row->expire_date));

                    $notif = array(
                    'name' => 'Truck Sticker',
                    'description' =>'Dear ' .$admin->name .', Truck '. $row->truck_name.' - ' . $row->reg_no.' sticker will expire on '. $due_date ,
                    'date' =>   date('Y-m-d'),
                    'from_user_id' => auth()->user()->added_by,
                     'added_by' => auth()->user()->added_by);
                       
                        Notification::create($notif); 
                    }
        }
                    
                    
            //insurance
          $iq = "SELECT trucks.id,trucks.truck_name,trucks.reg_no,MAX(truck_insurances.expire_date) AS expire_date FROM truck_insurances 
          LEFT JOIN trucks ON truck_insurances.truck_id =trucks.id WHERE truck_insurances.expire_date < '".$date."' AND truck_insurances.added_by='".$user."' GROUP BY truck_insurances.truck_id";
          $tid =  DB::select($iq);
        
        if(count($tid) > 0){
            
        foreach($tid as $row){

                    $notif = array(
                    'name' => 'Truck Insurance',
                    'description' =>'Dear ' .$admin->name .', Truck '. $row->truck_name.' - ' . $row->reg_no.' insurance will expire on '. $due_date  ,
                    'date' =>   date('Y-m-d'),
                    'from_user_id' => auth()->user()->added_by,
                     'added_by' => auth()->user()->added_by);
                       
                        Notification::create($notif); 
                    }
        }
                
      //tracking device
          $tiq = "SELECT trucks.id,trucks.truck_name,trucks.reg_no,MAX(truck_tracking_device.expire_date) AS expire_date FROM truck_tracking_device 
          LEFT JOIN trucks ON truck_tracking_device.truck_id =trucks.id WHERE truck_tracking_device.expire_date < '".$date."' AND truck_tracking_device.added_by='".$user."' GROUP BY truck_tracking_device.truck_id";
          $ttid =  DB::select($tiq);
        
        if(count($ttid) > 0){
            
        foreach($ttid as $row){

                    $notif = array(
                    'name' => 'Truck Tracking Device',
                    'description' =>'Dear ' .$admin->name .', Truck '. $row->truck_name.' - ' . $row->reg_no.' tracking device will expire on '. $due_date  ,
                    'date' =>   date('Y-m-d'),
                    'from_user_id' => auth()->user()->added_by,
                     'added_by' => auth()->user()->added_by);
                       
                        Notification::create($notif); 
                    }
        }
        
          //wma
          $wiq = "SELECT trucks.id,trucks.truck_name,trucks.reg_no,MAX(wma.expire_date) AS expire_date FROM wma 
          LEFT JOIN trucks ON wma.truck_id =trucks.id WHERE wma.expire_date < '".$date."' AND wma.added_by='".$user."' GROUP BY wma.truck_id";
          $wid =  DB::select($tiq);
        
        if(count($wid) > 0){
            
        foreach($wid as $row){

                    $notif = array(
                    'name' => 'Truck WMA',
                    'description' =>'Dear ' .$admin->name .', Truck '. $row->truck_name.' - ' . $row->reg_no.' WMA will expire on '. $due_date  ,
                    'date' =>   date('Y-m-d'),
                    'from_user_id' => auth()->user()->added_by,
                     'added_by' => auth()->user()->added_by);
                       
                        Notification::create($notif); 
                    }
        }
              
      
        
       
          $this->info('Truck Expire testing'); 
          
          
    }
}
