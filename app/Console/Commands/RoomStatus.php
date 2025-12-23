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

class RoomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roomstatus:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of room when check_in date equals to current date';

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
        
        $query =  "UPDATE hotel_booked_rooms SET status = 1 WHERE check_in = curdate() AND status = 0";
        
        $results =  DB::select($query);
       
          $this->info('Update status of room when check_in date equals to current date'); 
          
          
    }
}
