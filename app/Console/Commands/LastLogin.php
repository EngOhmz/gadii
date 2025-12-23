<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User_Roles;
use App\Models\LateLogins;
use App\Models\User_RolesCopy2;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Notification;

class LastLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking user last login in last 7 days';

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
        
        //$qnr  = User::where()
        
        $query =  "SELECT users.id  as user_id, users.added_by as added_by, users.email  as email, users.name as name, users.phone as phone, users.last_login as last_login, user_role_copy2.due_date as due_date FROM `users`  LEFT JOIN user_role_copy2 ON users.id = user_role_copy2.user_id WHERE users.last_login IS NOT NULL AND users.last_login <= CURDATE() - interval 7 day AND user_role_copy2.due_date >= CURDATE() GROUP by users.id";
        
        $results =  DB::select($query);
        
        
        if(count($results) > 0){
            
                foreach($results as $row){
                    
                  $user_exists =  LateLogins::where('user_id', $row->user_id)->first();
                  
                    if(!empty($user_exists)){
                        
                        $notif = array(
                        'name' => $row->name,
                        'phone' =>$row->phone ,
                        'email' =>   $row->email,
                      'user_id' => $row->user_id,
                      'added_by' => $row->added_by);
                       
                        $user_exists->update($notif); 
                        
                        
                    }
                    else{
                        
                        
                        $notif = array(
                        'name' => $row->name,
                        'phone' =>$row->phone ,
                        'email' =>   $row->email,
                      'user_id' => $row->user_id,
                      'added_by' => $row->added_by);
                       
                        LateLogins::create($notif); 
   
                        
                    }
                    
                        
                    
                    
                    
                
                //  $keyold = "891bf62609dcbefad622090d577294dcab6d0607";
                 
                //  $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
                 
                //   $number = $row->phone;
                // //   $number = "0620650846";
                
                // // https://sms.ema.co.tz/services/send.php?key=3b3e9650a2888de375cb46b285b4bea6e3a797e4&number=009999&message=hello&option=2&type=sms&prioritize=1
               
                // $message = "Dear $row->name, Act now! In just 3 days, your EMASUITE account expires, your package of $row->slug is expiring on $due_date. Pay now to seize the chance to simplify, manage, and grow your business smartly. Call +255655973248. Powered by UjuziNet.";
                //   $option11 = 1;
                //   $type = "sms";
                //   $useRandomDevice = 1;
                //   $prioritize = 1;
                  
                // //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
                  
                //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
            
                
                
                
            }
            
        }
        
        
      
      
        
       
          $this->info('Last Login in the 7 days'); 
          
          
    }
}
