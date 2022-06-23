<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Models\District;
use App\Models\Cotton\PurchaseCotton;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\ProductionActivity;
use App\Models\Cotton\Costants;
use App\Models\Cotton\CottonMovement;
use App\Models\User;
use DateTime;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $monthly_actual_expected_data = [];
         
        //  whereMonth('created_at', date('m'))
        //  $invoice = Payment::selectRaw('year(created_at) as year, monthname(created_at) as month, sum(total_amount) as total_sale')
        //     ->groupBy('year','month')
        //     ->orderByRaw('min(created_at) desc')
        //     ->get();
        $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
        for($i=1; $i<13; $i++){
           $monthNum  = $i;
           $dateObj   = DateTime::createFromFormat('!m', $monthNum);
           //$month = $dateObj->format('F');
           $month = 02;
           
                array_push($monthly_actual_expected_data, array(
                'month' => $months[$i],
                'cash' => JournalEntry::where('center_id','!=',null)->whereMonth('created_at', date("m", $month))->sum('debit'),
                'value_village' => PurchaseCotton::whereMonth('created_at', date("m", $month))->sum('purchase_amount')
            ));
            
        }
     
        $monthly_actual_expected_data = json_encode($monthly_actual_expected_data);
            
        $user_id=auth()->user()->id;
        $user=User::find($user_id);
        
        $cash_issued = JournalEntry::where('center_id','!=',null)->sum('debit');
        $district = District::all();
        $cotton_collected = PurchaseCotton::sum('quantity');
        $balance = CottonMovement::sum('quantity') -  ProductionActivity::where('type',3)->sum('production_quantity');
        $costants = Costants::all()->first();
        $expected['raw'] =10;
        $expected['dust'] = 2;
        $expected['seed'] = 3;
        $cotton_value = PurchaseCotton::sum('purchase_amount');
        return view('agrihub.dashboard',compact('cash_issued','district','cotton_collected','cotton_value','monthly_actual_expected_data','balance','expected'));
        
    }
}
