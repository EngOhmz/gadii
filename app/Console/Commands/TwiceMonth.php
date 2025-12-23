<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User_Roles;
use App\Models\User_RolesCopy2;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class TwiceMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twicemonth:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Greetings Sms in twice a month';

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
    
           $query2 =  "SELECT users.name,users.phone,roles.slug,user_role_copy2.due_date FROM `user_role_copy2` LEFT JOIN users ON user_role_copy2.user_id = users.added_by LEFT JOIN roles ON user_role_copy2.role_id = roles.id WHERE user_role_copy2.due_date <= curdate() AND users.name IS NOT NULL AND users.phone IS NOT NULL";
        
        $results2 =  DB::select($query2);
        
        if($results2->isNotEmpty()){
            
                foreach($results2 as $row2){
                
                //  $key = "891bf62609dcbefad622090d577294dcab6d0607";
                
                $key="3b3e9650a2888de375cb46b285b4bea6e3a797e4";
                
                  $number = $row2->phone;
                //   $number = "0620650846";
                //   $number = $data->msisdn;
                //   $message = "Dear $row2->name, Act now! In just 1 day, your EMASUITE account expires, your account of $row2->slug is expiring at $row2->due_date. Pay now to seize the chance to simplify, manage, and grow your business smartly. Call +255655973248. Powered by UjuziNet.";
                  $message = "Hello $row2->name, how's your business? We value your choice of EMASUITE. Let us know if you face any system challenges or need business connections. Contact: +255655973248. Boost your business with EMASUITE. Powered by UjuziNet.";
                    // $message = "Hello, your farm ph scale is $farmer->ph, moisture level is $farmer->moisture, nitrogen level is $farmer->nitrogen, potassium level is $farmer->potassium and lastly phosphorus level is $farmer->phosphorus. \n Thank You For measuring your farm with us.  \n Powered by UjuziNet.";
                  $option11 = 1;
                  $type = "sms";
                  $useRandomDevice = 1;
                  $prioritize = 1;
                  
                //   $response2 = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&devices=1&type=sms&useRandomDevice=1&prioritize=1")->json();
                  
                  $response2 = Http::withHeaders(['Content-Type' => 'application/json'])->send('GET',"https://sms.ema.co.tz/services/send.php?key=$key&number=$number&message=$message&option=1&type=sms&prioritize=0 ")->json();
            
                
                
                
            }
            
        }
        
          $this->info('Twice a month first a day sms testing'); 
          
          
    }
}
