<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Models\ClassAccount;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\Deposit;
use App\Models\Expenses;
use App\Models\Truck;
use App\Models\Client;
use App\Models\Mileage;
use App\Models\Pacel\PacelInvoice;
use App\Models\Fuel\Fuel;
use App\Models\Permit\Permit;
use App\Models\Tyre\Tyre;
use App\Models\CargoCollection;
use App\Models\CargoLoading;
use App\Models\Courier\CourierInvoice;
use App\Models\Courier\CourierLoading;
use App\Models\Courier\CourierCollection;
use App\Models\Courier\CourierClient;
use App\Models\Driver;
use App\Models\POS\Invoice;
use App\Models\POS\Purchase;
use App\Models\Payroll\SalaryPayment;

use App\Models\POS\Items ;
use App\Models\Supplier;
use App\Models\School\School;
use App\Models\School\Student;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Models\Project\Project;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelItems;
use App\Models\Hotel\Invoice as BookingInvoice;
use App\Models\User;
use App\Models\Notification;
use App\Models\System;
use App\Models\Currency;
use DateTime;
use Carbon\Carbon;

use App\Models\User_Roles;
use App\Models\User_RolesCopy2;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showChangePswd(){
        return view('auth.change_password');
    }

    public function changePswd(Request $request){
        if(!Hash::check($request->get('current-password'), Auth::user()->password)){
            //check if password matches

            return back()->with('error', 'Curent Password does not match with Old Password');
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                //current password and new password are the same
                return back()->with('error', 'New password can not be the same as your old password change to new one');
        }

        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed'
        ]);

        // update password

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->get('new-password'))
        ]);
        
        
          
         $notif = array(
         'name' => 'Change Password',
        'description' =>'Your Password has been changed'  ,
         'date' =>   date('Y-m-d'),
          'from_user_id' =>auth()->user()->id,
          'added_by' => auth()->user()->added_by);
           
            Notification::create($notif);  

        return back()->with('success', 'Password changed successfully');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

       //
        $currency= Currency::all();

        //transaction
         $deposit=Deposit::where('added_by',auth()->user()->added_by)->where('status','1')->sum('amount');
         $expense=Expenses::where('multiple','1')->where('added_by',auth()->user()->added_by)->where('status','1')->sum('amount');

         //cargo
         $client=Client::where('user_id',auth()->user()->added_by)->count();        
         $invoice= PacelInvoice::where('added_by',auth()->user()->added_by)->whereYear('date', date('Y'))->sum(\DB::raw('amount * exchange_rate'));
         $due= PacelInvoice::where('added_by',auth()->user()->added_by)->whereYear('date', date('Y'))->sum(\DB::raw('due_amount * exchange_rate'));        
          $collection=CargoCollection::where('status','2')->where('added_by',auth()->user()->added_by)->count();
          $loading= CargoLoading::where('status','3')->where('added_by',auth()->user()->added_by)->count();
         $off= CargoLoading::where('status','4')->where('added_by',auth()->user()->added_by)->count();
          $del= CargoLoading::where('status','5')->where('added_by',auth()->user()->added_by)->count();
          $dest= CargoLoading::where('status','6')->where('added_by',auth()->user()->added_by)->count();
          $trips= CargoLoading::where('added_by',auth()->user()->added_by)->count();

      //logistic
        $truck=Truck::where('disabled',0)->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->count();
          $driver=Driver::where('disabled',0)->where('added_by',auth()->user()->added_by)->count();
          $mileage=Mileage::where('added_by',auth()->user()->added_by)->sum('total_mileage');
         $permit=Permit::where('added_by',auth()->user()->added_by)->sum('total_permit');
           $fuel=Fuel::where('added_by',auth()->user()->added_by)->sum('fuel_used');
         $tire=Tyre::where('status','!=','3')->where('added_by',auth()->user()->added_by)->count();


      //pos
      $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->sum(\DB::raw('due_amount * exchange_rate')); 
       $pos_supplier=Supplier::where('user_id',auth()->user()->added_by)->where('disabled',0)->count();
          $pos_item =Items::where('added_by',auth()->user()->added_by)->where('disabled',0)->count();
         $pos_client=Client::where('owner_id',auth()->user()->added_by)->where('disabled',0)->count(); 
         
         $day_item=Items::where('added_by',auth()->user()->added_by)->where('disabled',0)->whereDate('created_at',date('Y-m-d'))->count();
         $week_item=Items::where('added_by',auth()->user()->added_by)->where('disabled',0)->whereBetween('created_at', [Carbon::parse('last sunday'),Carbon::now()])->count();
         $month_item=Items::where('added_by',auth()->user()->added_by)->where('disabled',0)->whereMonth('created_at',date('m'))->count();
         
           if(auth()->user()->added_by == auth()->user()->id){
         
         $day_pur=Purchase::where('added_by',auth()->user()->added_by)->whereDate('approval_date',date('Y-m-d'))->whereIn('status', [1,2,3])->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
         $week_pur=Purchase::where('added_by',auth()->user()->added_by)->whereBetween('approval_date', [Carbon::parse('last sunday'),Carbon::now()])->whereIn('status', [1,2,3])->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
         $month_pur=Purchase::where('added_by',auth()->user()->added_by)->whereMonth('approval_date',date('m'))->whereIn('status', [1,2,3])->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
         
         
         $day_inv=Invoice::where('added_by',auth()->user()->added_by)->whereDate('invoice_date',date('Y-m-d'))->where('invoice_status','1')->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount) * exchange_rate'));
         $week_inv=Invoice::where('added_by',auth()->user()->added_by)->whereBetween('invoice_date', [Carbon::parse('last sunday'),Carbon::now()])->where('invoice_status','1')->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount) * exchange_rate'));
         $month_inv=Invoice::where('added_by',auth()->user()->added_by)->whereMonth('invoice_date',date('m'))->where('invoice_status','1')->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount) * exchange_rate'));
         
           }
           
           
           else{
               $day_pur=Purchase::where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->whereDate('approval_date',date('Y-m-d'))->whereIn('status', [1,2,3])->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
         $week_pur=Purchase::where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->whereBetween('approval_date', [Carbon::parse('last sunday'),Carbon::now()])->whereIn('status', [1,2,3])->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
         $month_pur=Purchase::where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->whereMonth('approval_date',date('m'))->whereIn('status', [1,2,3])->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
         
         
         $day_inv=Invoice::where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->whereDate('invoice_date',date('Y-m-d'))->where('invoice_status','1')->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount) * exchange_rate'));
         $week_inv=Invoice::where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->whereBetween('invoice_date', [Carbon::parse('last sunday'),Carbon::now()])->where('invoice_status','1')->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount) * exchange_rate'));
         $month_inv=Invoice::where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->whereMonth('invoice_date',date('m'))->where('invoice_status','1')->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount) * exchange_rate')); 
               
           }
         
         
         $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
         if(!empty($cos)){
         $cogs_dr=JournalEntry::where('added_by',auth()->user()->added_by)->where('account_id', $cos->id)->where('added_by', auth()->user()->added_by)->where('year', date('Y'))->sum(\DB::raw('debit'));
         $cogs_cr=JournalEntry::where('added_by',auth()->user()->added_by)->where('account_id', $cos->id)->where('added_by', auth()->user()->added_by)->where('year', date('Y'))->sum(\DB::raw('credit'));
        $cogs=$cogs_dr - $cogs_cr;
         }
         else{
          $cogs=0;   
         }
         
         //pms
          $booking= BookingInvoice::where('added_by',auth()->user()->added_by)->whereYear('invoice_date', date('Y'))->whereIn('status', [2,3])->count();
         $property=Hotel::where('added_by',auth()->user()->added_by)->where('disabled','0')->count(); ;
         $rooms=HotelItems::where('added_by',auth()->user()->added_by)->count(); ;
         
           //project
                $tasks = Task::where('added_by',auth()->user()->added_by)->where('disabled','0')->count(); ;
                $milestone = Milestone::where('disabled','0')->where('added_by',auth()->user()->added_by)->count(); ;
               $projects= Project::where('added_by',auth()->user()->added_by)->where('disabled','0')->count(); ;
              $recent_pro=Project::where('added_by',auth()->user()->added_by)->where('disabled','0')->orderBy('start_date','desc')->take(5)->get(); ;
              
              //notifications
              
              $notif=Notification::where('added_by',auth()->user()->added_by)->orderBy('created_at','desc')->take(10)->get(); ;
              $unread=Notification::where('added_by',auth()->user()->added_by)->where('read','1')->count(); ;

      $monthly_pos_data = [];

        $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
        
        for($i=1; $i<13; $i++){
            $purchase = 0;
            $sales = 0;
                     
          (int)$sales_result =Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->whereMonth('invoice_date',$i)->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount ) * exchange_rate'));
                  $sales = $sales + $sales_result ; 

   (int)$purchase_result =Purchase::where('added_by',auth()->user()->added_by)->whereIn('status', [1,2,3])->whereYear('approval_date', date('Y'))->whereMonth('approval_date',$i)->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
                  $purchase = $purchase + $purchase_result ;    
                        
                array_push($monthly_pos_data, array(
                'month' => $months[$i],
                'sales' => $sales,
                'purchase' => $purchase
            ));
            
        }
     
        $monthly_pos_data = json_encode($monthly_pos_data);
            


    //courier
   $courier_invoice= CourierInvoice::where('added_by',auth()->user()->added_by)->whereYear('date', date('Y'))->sum(\DB::raw('amount * exchange_rate'));
         $courier_due=CourierInvoice::where('added_by',auth()->user()->added_by)->whereYear('date', date('Y'))->sum(\DB::raw('due_amount * exchange_rate'));
    $cou_collection=CourierCollection::where('status','2')->where('added_by',auth()->user()->added_by)->count();
          $cou_loading= CourierLoading::where('status','3')->where('added_by',auth()->user()->added_by)->count();
         $cou_off= CourierLoading::where('status','4')->where('added_by',auth()->user()->added_by)->count();
          $cou_del= CourierLoading::where('status','5')->where('added_by',auth()->user()->added_by)->count();
          $cou_dest= CourierLoading::where('status','6')->where('added_by',auth()->user()->added_by)->count();
          $cou_trips=CourierLoading::where('added_by',auth()->user()->added_by)->count();
          $courier_client=CourierClient::where('added_by',auth()->user()->added_by)->count();

       

          //school
          $students=Student::where('added_by',auth()->user()->added_by)->count();
          $sch_inv=StudentPayment::where('added_by',auth()->user()->added_by)->sum('fee');
          $sch_pay=SchoolPayment::where('added_by',auth()->user()->added_by)->where('type','!=','Discount Fees')->sum('paid');
          $sch_dis=SchoolPayment::where('added_by',auth()->user()->added_by)->where('type','Discount Fees')->sum('paid');


            //subscription
            $total_azam=DB::table('integration_deposits')->where('status', '2')->sum('amount');

               //payroll
           $payments= SalaryPayment::select([
                DB::raw('MONTHNAME(STR_TO_DATE(payment_month,"%Y-%m-%d")) as month'),
                DB::raw('sum(payment_amount) as amount'),    
                 DB::raw('MONTH(STR_TO_DATE(payment_month,"%Y-%m-%d")) as month_no'),         
            ])
             ->where( DB::raw('YEAR(STR_TO_DATE(payment_month,"%Y-%m-%d"))'), '=', date('Y')) 
             ->where('added_by',auth()->user()->added_by)
            ->groupBy('month')
        ->orderBy('month_no')
            ->get();
          
             

if(!empty($payments[0])){
  foreach($payments as $row){
               $month[]=$row['month'];
                 $amount[]=$row['amount'];

} 

}

else{

                $month[]='';
                 $amount[]='';
}


    $settings= System::where('added_by',auth()->user()->added_by)->first();
    
    $user_type = User::find(auth()->user()->id)->user_type;

if($user_type == 'affiliate'){
    return view('agrihub.affiliate_dashboard');
}
else if($user_type == 'ema80x'){
    return view('agrihub.ema80x_dashboard');
}
else{
    
    $nowDT = Carbon::now();
    
    $usrRoles = User_RolesCopy2::where('user_id', auth()->user()->added_by)->whereDate('due_date', '<', $nowDT)->get();
    
    if($usrRoles->isNotEmpty()){
        
        foreach($usrRoles as $row22){
            
            $usr_rol = User_Roles::where('user_id', $row22->user_id)->where('role_id', $row22->role_id)->first();
            
            if(!empty($usr_rol)){
                
                $xyzDD =  User::find($usr_rol->user_id);
                
                $expire_role = $row22->role_id;
                
                $rolesunder = Role::where('added_by', auth()->user()->added_by)->get();
                
                    if($rolesunder->isNotEmpty()){
                
                        foreach($rolesunder as $underss){
                            
                            $role_id = $underss->id;
                            
                            
                            
                            $query = "UPDATE roles_permissions rp set rp.status = 0 WHERE  rp.role_id = '".$role_id."' and rp.permission_id IN (SELECT permission_id from roles_permissions where roles_permissions.role_id = '".$expire_role."')";
                            $row = DB::insert(DB::raw($query));
                            
                            // dd($row);
           
                            
                        }
                
                    }
                
                
                $ttupdt =  $xyzDD->update(['mobile_status' => 'inactive']);
                
                $xyzDD->roles()->detach($usr_rol->role_id);
                
                // dd($expire_role);
            }
            
            
            
        }
        
        $countUr = User_Roles::where('user_id', auth()->user()->added_by)->count();
        
        if($countUr == 0){
            
            return view('subscribe');
            
            
        }
        else{
            
            $user_id77 = auth()->user()->id;
            
            // $permission_id =  
            
            $query =  " SELECT rp.* from roles_permissions rp,users_roles ur where rp.role_id = ur.role_id and ur.user_id = '".$user_id77."' and rp.status = 1";
            $row = DB::select(DB::raw($query));
    
            
            if(count($row) > 0){
                
                if(!empty($settings)){
                    return view('agrihub.dashboard',
                        compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
                        'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
                        'students','sch_inv','sch_pay','sch_dis','recent_pro','projects','tasks','milestone','booking','property','rooms','notif','unread',
                        'day_item','week_item','month_item','day_pur','week_pur','month_pur','day_inv','week_inv','month_inv','total_azam'
                        ));
                    }
                    else{
                        
                        return view('agrihub.dashboard23',compact('currency'));
                    }
                
            }
            else{
                
                return view('subscribe');
                
            }
            
            
            
        }
        
    }
    else{
        
        if(!empty($settings)){
            return view('agrihub.dashboard',
                compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
                'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
                'students','sch_inv','sch_pay','sch_dis','recent_pro','projects','tasks','milestone','booking','property','rooms','notif','unread',
                'day_item','week_item','month_item','day_pur','week_pur','month_pur','day_inv','week_inv','month_inv','total_azam'
                ));
            }
            else{
                
                return view('agrihub.dashboard23',compact('currency'));
            }
        
    }
    
    
    
    
    
    // if(!empty($settings)){
    // return view('agrihub.dashboard',
    //     compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
    //     'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
    //     'students','sch_inv','sch_pay','recent_pro','projects','tasks','milestone'));
    // }
    // else{
        
    //     return view('agrihub.dashboard23',,compact('currency'));
    // }

}




        
    }
    
    
    
       public function format_number(Request $request)
    {
        //dd($request->all());
       $id=str_replace(",","",$request->id);
       if($id > 999){
       $price=number_format($id,2);
       }
       else{
        $price=$id;   
       }
            

            return response()->json($price);
        
    }
    
    


}
