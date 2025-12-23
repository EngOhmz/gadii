<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class GreetingsWelcome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'greetings:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Greetings Sms';

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
        // return 0;
        
        // $nowDT = Carbon::now();
    
        // $usrRoles = User_RolesCopy2::where('user_id', auth()->user()->added_by)->whereDate('due_date', '<', $nowDT)->get();
        
        // if($usrRoles->isNotEmpty()){
            
        //     foreach($usrRoles as $row22){
                
        //         $usr_rol = User_Roles::where('user_id', $row22->user_id)->where('role_id', $row22->role_id)->first();
                
        //         if(!empty($usr_rol)){
                    
        //             $xyzDD =  User::find($usr_rol->user_id);
                    
        //             $expire_role = $row22->role_id;
                    
        //             $rolesunder = Role::where('added_by', auth()->user()->added_by)->get();
                    
        //                 if($rolesunder->isNotEmpty()){
                    
        //                     foreach($rolesunder as $underss){
                                
        //                         $role_id = $underss->id;
                                
                                
                                
        //                         $query = "UPDATE roles_permissions rp set rp.status = 0 WHERE  rp.role_id = '".$role_id."' and rp.permission_id IN (SELECT permission_id from roles_permissions where roles_permissions.role_id = '".$expire_role."')";
        //                         $row = DB::insert(DB::raw($query));
                                
        //                         // dd($row);
               
                                
        //                     }
                    
        //                 }
                    
                    
        //             $ttupdt =  $xyzDD->update(['mobile_status' => 'inactive']);
                    
        //             $xyzDD->roles()->detach($usr_rol->role_id);
                    
        //             // dd($expire_role);
        //         }
                
                
                
        //     }
            
        //     $countUr = User_Roles::where('user_id', auth()->user()->added_by)->count();
            
        //     if($countUr == 0){
                
        //         return view('subscribe');
                
                
        //     }
        //     else{
                
        //         $user_id77 = auth()->user()->id;
                
        //         // $permission_id =  
                
        //         $query =  " SELECT rp.* from roles_permissions rp,users_roles ur where rp.role_id = ur.role_id and ur.user_id = '".$user_id77."' and rp.status = 1";
        //         $row = DB::select(DB::raw($query));
        
                
        //         if(count($row) > 0){
                    
        //             if(!empty($settings)){
        //                 return view('agrihub.dashboard',
        //                     compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
        //                     'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
        //                     'students','sch_inv','sch_pay','recent_pro','projects','tasks','milestone','booking','property','rooms','notif','unread'));
        //                 }
        //                 else{
                            
        //                     return view('agrihub.dashboard23');
        //                 }
                    
        //         }
        //         else{
                    
        //             return view('subscribe');
                    
        //         }
                
                
                
        //     }
            
        // }
        
        $key = "891bf62609dcbefad622090d577294dcab6d0607";
          $number = "0747022515";
        //   $number = "0620650846";
        //   $number = $data->msisdn;
        //   $message = "Thank you $member->full_name, $member->member_id, for depositing Tsh. $data->amount on $dateT with receipt no: $data->reference to Gymkhana Club. Your deposit balance is now Tsh. $member->balance. \n Powered by UjuziNet.";
          $message = "Thank you for testing sms cron job.  \n Powered by UjuziNet.";
            // $message = "Hello, your farm ph scale is $farmer->ph, moisture level is $farmer->moisture, nitrogen level is $farmer->nitrogen, potassium level is $farmer->potassium and lastly phosphorus level is $farmer->phosphorus. \n Thank You For measuring your farm with us.  \n Powered by UjuziNet.";
          $option11 = 1;
          $type = "sms";
          $useRandomDevice = 1;
          $prioritize = 1;
          
          $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
          
          $this->info('Sms testing'); 
          
          
    }
}
