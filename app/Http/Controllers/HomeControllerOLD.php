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
use App\Models\Pharmacy\Purchase as PharPurchase;
use App\Models\Pharmacy\Invoice as PharInvoice;
use App\Models\Pharmacy\Items as PharItems;
use App\Models\Pharmacy\Supplier as PharSupplier;
use App\Models\Pharmacy\Client as PharClient;
use App\Models\POS\Items ;
use App\Models\Supplier;
use App\Models\School\School;
use App\Models\School\Student;
use App\Models\School\StudentPayment;
use App\Models\School\SchoolPayment;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Models\Project\Project;
use App\Models\User;
use App\Models\System;
use DateTime;
use Carbon\Carbon;
use DB;

use App\Models\User_Roles;
use App\Models\User_RolesCopy2;

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

        return back()->with('success', 'Password changed successfully');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {



        //transaction
         $deposit=Deposit::where('added_by',auth()->user()->added_by)->where('status','1')->sum('amount');
         $expense=Expenses::where('multiple','0')->where('added_by',auth()->user()->added_by)->where('status','1')->sum('amount');

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
      $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));
         $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->whereYear('invoice_date', date('Y'))->sum(\DB::raw('due_amount * exchange_rate')); 
       $pos_supplier=Supplier::where('user_id',auth()->user()->added_by)->count();
          $pos_item =Items::where('added_by',auth()->user()->added_by)->count();
         $pos_client=Client::where('user_id',auth()->user()->added_by)->count(); 
         $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
         if(!empty($cos)){
         $cogs_dr=JournalEntry::where('added_by',auth()->user()->added_by)->where('account_id', $cos->id)->where('added_by', auth()->user()->added_by)->where('year', date('Y'))->sum(\DB::raw('debit'));
         $cogs_cr=JournalEntry::where('added_by',auth()->user()->added_by)->where('account_id', $cos->id)->where('added_by', auth()->user()->added_by)->where('year', date('Y'))->sum(\DB::raw('credit'));
        $cogs=$cogs_dr - $cogs_cr;
         }
         else{
          $cogs=0;   
         }
           //project
                $tasks = Task::where('added_by',auth()->user()->added_by)->where('disabled','0')->count(); ;
                $milestone = Milestone::where('disabled','0')->where('added_by',auth()->user()->added_by)->count(); ;
               $projects= Project::where('added_by',auth()->user()->added_by)->where('disabled','0')->count(); ;
              $recent_pro=Project::where('added_by',auth()->user()->added_by)->where('disabled','0')->orderBy('start_date','desc')->take(5)->get(); ;

      $monthly_pos_data = [];

        $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
        
        for($i=1; $i<13; $i++){
            $purchase = 0;
            $sales = 0;
                     
          (int)$sales_result =Invoice::where('added_by',auth()->user()->added_by)->where('good_receive','1')->whereYear('invoice_date', date('Y'))->whereMonth('invoice_date',$i)->sum(\DB::raw('( (invoice_amount + invoice_tax + shipping_cost) - discount ) * exchange_rate'));
                  $sales = $sales + $sales_result ; 

   (int)$purchase_result =Purchase::where('added_by',auth()->user()->added_by)->where('good_receive','1')->whereYear('purchase_date', date('Y'))->whereMonth('purchase_date',$i)->sum(\DB::raw('( (purchase_amount + purchase_tax + shipping_cost) - discount) * exchange_rate'));
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
else{
    
    $nowDT = Carbon::now();
    
    $usrRoles = User_RolesCopy2::where('user_id', auth()->user()->added_by)->whereDate('due_date', '<', $nowDT)->get();
    
    if($usrRoles->isNotEmpty()){
        
        foreach($usrRoles as $row22){
            
            $usr_rol = User_Roles::where('user_id', $row22->user_id)->where('role_id', $row22->role_id)->first();
            
            $xyzDD =  $usr_rol->delete();
            
        }
        
        $countUr = User_Roles::where('user_id', auth()->user()->added_by)->count();
        
        if($countUr == 0){
            
            return view('subscribe');
            
            
        }
        else{
            
            if(!empty($settings)){
            return view('agrihub.dashboard',
                compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
                'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
                'students','sch_inv','sch_pay','recent_pro','projects','tasks','milestone'));
            }
            else{
                
                return view('agrihub.dashboard23');
            }
            
        }
        
    }
    else{
        
        if(!empty($settings)){
            return view('agrihub.dashboard',
                compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
                'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
                'students','sch_inv','sch_pay','recent_pro','projects','tasks','milestone'));
            }
            else{
                
                return view('agrihub.dashboard23');
            }
        
    }
    
    
    
    
    
    // if(!empty($settings)){
    // return view('agrihub.dashboard',
    //     compact('deposit','expense','client','truck','invoice','due','mileage','permit','fuel','tire','trips','collection','loading','off','del','dest','pos_invoice','pos_due','payments','month','amount','driver',
    //     'cou_collection','cou_loading','cou_off','cou_del','cou_dest','cou_trips','courier_invoice','courier_due','courier_client','pos_item','pos_supplier','pos_client','cogs','monthly_pos_data',
    //     'students','sch_inv','sch_pay','recent_pro','projects','tasks','milestone'));
    // }
    // else{
        
    //     return view('agrihub.dashboard23');
    // }

}





        
        
    }


}
