<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Notification;

class BeforeNumDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beforenum:days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire sms before number of days';

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
        
        $query =  "SELECT user_role_copy2.user_id,users.name,users.phone,roles.slug,user_role_copy2.due_date FROM `user_role_copy2` LEFT JOIN users ON user_role_copy2.user_id = users.id LEFT JOIN roles ON user_role_copy2.role_id = roles.id WHERE user_role_copy2.due_date = curdate() + 3";
        
        $results =  DB::select($query);
        
        
        if(count($results) > 0){
            
                foreach($results as $row){
                    
                     $admin=User::where('email','info@ujuzinet.com')->first();
                     $due_date=date('d/m/Y', strtotime($row->due_date));
                    
                    $notif = array(
                        'name' => 'User Expire',
                        'description' =>'Dear ' .$row->name .', Your '. $row->slug.' package will expire in 3 days.Please Pay before '. $due_date.'  to continue to enjoy our services'  ,
                        'date' =>   date('Y-m-d'),
                      'to_user_id' => $row->user_id,
                      'added_by' => $row->user_id);
                       
                        Notification::create($notif); 
                        
                        
                        
                        $ema_notif = array(
                        'name' => 'User Expire',
                        'description' =>'User ' .$row->name .', with '. $row->slug.' package will expire in 3 days.Subscription will end on '. $due_date  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => $admin->id,
                        'to_user_id' => $row->user_id,
                         'added_by' => $admin->added_by);
                       
                        Notification::create($ema_notif); 
                        
                        
                        
                         $admin_notif = array(
                        'name' => 'User Registration',
                        'description' =>'User ' .$row->name .', with '. $row->slug.' package will expire in 3 days.Subscription will end on '. $due_date  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => '1',
                        'to_user_id' => $row->user_id,
                         'added_by' => '1');
                       
                        Notification::create($admin_notif); 
                    
                    
                    
                
                //  $keyold = "891bf62609dcbefad622090d577294dcab6d0607";
                 
                 $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
                 
                  $number = $row->phone;
                //   $number = "0620650846";
                
                // https://sms.ema.co.tz/services/send.php?key=3b3e9650a2888de375cb46b285b4bea6e3a797e4&number=009999&message=hello&option=2&type=sms&prioritize=1
               
                $message = "Dear $row->name, Act now! In just 3 days, your EMASUITE account expires, your package of $row->slug is expiring on $due_date. Pay now to seize the chance to simplify, manage, and grow your business smartly. Call +255655973248. Powered by UjuziNet.";
                  $option11 = 1;
                  $type = "sms";
                  $useRandomDevice = 1;
                  $prioritize = 1;
                  
                //   $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
                  
                  $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
            
                
                
                
            }
            
        }
        
        
        $query2 =  "SELECT user_role_copy2.user_id,users.name,users.phone,roles.slug,user_role_copy2.due_date FROM `user_role_copy2` LEFT JOIN users ON user_role_copy2.user_id = users.id LEFT JOIN roles ON user_role_copy2.role_id = roles.id WHERE user_role_copy2.due_date = curdate() + 1";
        
        $results2 =  DB::select($query2);
        
        if(count($results2) > 0){
            
                foreach($results2 as $row2){
                    
                    
                        $admin=User::where('email','info@ujuzinet.com')->first();
                     $due_date2=date('d/m/Y', strtotime($row2->due_date));
                    
                    $notif = array(
                        'name' => 'User Expire',
                        'description' =>'Dear ' .$row2->name .', Your '. $row2->slug.' package will expire in 1 days.Please Pay before '. $due_date2.'  to continue to enjoy our services'  ,
                        'date' =>   date('Y-m-d'),
                      'to_user_id' => $row2->user_id,
                      'added_by' => $row2->user_id);
                       
                        Notification::create($notif); 
                        
                        
                        
                        $ema_notif = array(
                        'name' => 'User Expire',
                        'description' =>'User ' .$row2->name .', with '. $row2->slug.' package will expire in 1 days.Subscription will end on '. $due_date2  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => $admin->id,
                        'to_user_id' => $row2->user_id,
                         'added_by' => $admin->added_by);
                       
                        Notification::create($ema_notif); 
                        
                        
                        
                         $admin_notif = array(
                        'name' => 'User Registration',
                        'description' =>'User ' .$row2->name .', with '. $row2->slug.' package will expire in 1 days.Subscription will end on '. $due_date2  ,
                        'date' =>   date('Y-m-d'),
                        'from_user_id' => '1',
                        'to_user_id' => $row2->user_id,
                         'added_by' => '1');
                       
                        Notification::create($admin_notif); 
                    
                
                //  $keyold = "891bf62609dcbefad622090d577294dcab6d0607";
                
                $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
                  $number = $row2->phone;
                //   $number = "0620650846";
                //   $number = $data->msisdn;
                  $message = "Dear $row2->name, Act now! In just 1 day, your EMASUITE account expires, your account of $row2->slug is expiring on $due_date2. Pay now to seize the chance to simplify, manage, and grow your business smartly. Call +255655973248. Powered by UjuziNet.";
        
                  $option11 = 1;
                  $type = "sms";
                  $useRandomDevice = 1;
                  $prioritize = 1;
                  
                //   $response2 = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
               
               $response = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
               
                
                
                
            }
            
        }
        
        
      
        
       
          $this->info('Before number days testing'); 
          
          
    }
}
