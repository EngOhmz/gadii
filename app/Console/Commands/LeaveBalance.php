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

class LeaveBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update number of leave days by 28 on 1st january every year';

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
        
        $query =  "UPDATE users SET leave_balance = leave_balance + 28";
        
        $results =  DB::select($query);
       
          $this->info('Update number of leave days by 28 on 1st january every year'); 
          
          
    }
}
