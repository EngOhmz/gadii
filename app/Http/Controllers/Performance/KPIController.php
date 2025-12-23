<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Models\Performance\Indicator;
use App\Models\Performance\Appraisal;
use App\Models\Performance\KPI;
use App\Models\Performance\KPIList;
use App\Models\Performance\KPIResult;
use App\Models\Performance\KPIResultList;
use App\Models\Goal_Tracking\Achievement;
use App\Models\Goal_Tracking\GoalTracking;
use App\Models\Goal_Tracking\GoalAssignment;
use App\Models\POS\Invoice;
use App\Models\POS\InvoicePayments;
use App\Models\Expenses;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Departments;
use App\Models\Designation;
use Illuminate\Http\Request;

class KPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list= KPI::where('added_by',auth()->user()->added_by)->get();;
        $department=Departments::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
         
       return view('performance.kpi',compact('list','department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         $data = $request->except('area','indicator');
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

         $kpi=KPI::create($data);
         
          $nameArr =$request->area ;
          $inArr = $request->indicator  ;
          
           if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $items = array(
                         'area' => $nameArr[$i],
                        'indicator' => $inArr[$i],
                        'department_id' =>   $request->department_id,
                        'designation_id' => $request->designation_id,
                         'user_id' =>  auth()->user()->id,
                        'added_by' => auth()->user()->added_by,
                        'kpi_id' =>$kpi->id);
                       
                       KPIList::create($items);  ;
    
    
                }
            }

           
        }    
        
       

        return redirect(route('kpi.index'))->with(['success'=>'Created Successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data=KPI::find($id);
        $items=KPIList::where('kpi_id',$id)->get();
        $department=Departments::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
        $designation= Designation::where('department_id', $data->department_id)->get();
       return view('performance.kpi',compact('department','data','id','items','designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $inv=KPI::find($id);
        
        
         $data=$request->except('area','indicator');
         $inv->update($data);
         
         $nameArr =$request->area ;
         $inArr = $request->indicator  ;
          $remArr = $request->removed_id ;
         $expArr = $request->saved_id ;
         
         
          if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    KPIList::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
               
               
                if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    $items = array(
                         'area' => $nameArr[$i],
                        'indicator' => $inArr[$i],
                        'department_id' =>   $request->department_id,
                        'designation_id' => $request->designation_id,
                         'user_id' =>  auth()->user()->id,
                        'added_by' => auth()->user()->added_by,
                        'kpi_id' =>$id);
                        
                         if(!empty($expArr[$i])){
                               KPIList::where('id',$expArr[$i])->update($items);  
          
          }
          else{
                       
                       KPIList::create($items);  ;
                       
          }
    
    
                }
            }

           
        }    
        

        return redirect(route('kpi.index'))->with(['success'=>'Updated Successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $issue = KPI::find($id);
        $issue->delete();

        return redirect(route('kpi.index'))->with(['success'=>'Deleted Successfully.']);
    }
    
    public function checkDesignation(Request $request){
        
         
$dep=$request->id;
$chk=$request->check;

if(!empty($chk)){
$before= KPI::find($chk); 

if($dep == $before->designation_id){
$price='' ;    
}

else{
$data=KPI::where('designation_id',$dep)->first();

if(!empty($data)){
$price="Performance Indicator has already been set for this designation" ;
}

else{
$price='' ;
 }
 
}  
  
    
}

else{
    
$data=KPI::where('designation_id',$dep)->first();

if(!empty($data)){
$price="Performance Indicator has already been set for this designation" ;
}

else{
$price='' ;
 }

}



                return response()->json($price);
    }
    
    public function findUser(Request $request)
    {
 
$user=$request->id;

$chk_user=User::find($user);


 if (!empty($chk_user->designation_id)) {
     
$dep=Designation::find($chk_user->designation_id);
$chk_dep=KPI::where('designation_id',$chk_user->designation_id)->first();

if (empty($chk_dep)){
$price="Please set indicator for user's Designation. The Designation is  ".  $dep->name ;

}
else{
$before=KPIResult::where('user_id',$user)->where('active','0')->first();

if (!empty($before)){
$price="You can not assign new KPI.Close the active one first. " ;
}
  
  else{  
$price='' ;
 }


}

}else{
$price="You can not assign KPI . Please set designation for the User ".  $chk_user->name ;
}



                return response()->json($price);                      
 
    }


 public function save_goal(Request $request){
       
      //dd($request->all());

      $data = $request->all();

        $data['added_by'] = auth()->user()->added_by;

        $trans_id = $request->trans_id;
        $data['assigned_to'] = implode(',', $trans_id);

        if (Carbon::now() < Carbon::parse($request->start_date)->format('Y-m-d')) {
            $data['status'] = 'Not Started';
        } elseif (Carbon::now() >= Carbon::parse($request->start_date)->format('Y-m-d') && Carbon::now() < Carbon::parse($request->end_date)->format('Y-m-d') ) {
            $data['status'] = 'On Going';
        } elseif (Carbon::now() > Carbon::parse($request->end_date)->format('Y-m-d')) {
            $data['status'] = 'Ended';
        }

        $save = GoalTracking::create($data);

        if (!empty($trans_id)) {
            for ($i = 0; $i < count($trans_id); $i++) {
                if (!empty($trans_id[$i])) {
                    $data_ass['goal_id'] = $save->id;
                    $data_ass['user_id'] = $trans_id[$i];
                    $data_ass['added_by'] = auth()->user()->added_by;

                    GoalAssignment::create($data_ass);
                }
            }
        }

        
      

        if (!empty($save)) {   
            
     
            return response()->json($save);
         }

       
   }
   
   
   public function findPercent(Request $request)
    {
 
$id=$request->id;
$user=$request->user;

 $save = GoalTracking::find($id);

       $expense = Expenses::where('multiple', '0')
            ->where('added_by', auth()->user()->added_by)
            ->where('user_id', $user)
            ->sum('amount');
        $fixed = Invoice::where('good_receive', 1)
            ->where('added_by', auth()->user()->added_by)
            ->where('user_id', $user)
            ->sum(\DB::raw('(invoice_amount + invoice_tax) * exchange_rate'));
            
            $payment = InvoicePayments::where('added_by', auth()->user()->added_by)
            ->where('user_id', $user)
            ->sum('amount');

        if ($save->achievement_id == '1') {
            
            if($fixed > 0){
            $total = ($save->target_amount / $fixed) * 100;
            }
            
            else{
             $total=0;   
            }
            
            
        } elseif ($save->achievement_id == '2') {
             if($payment > 0){
            $total = ($save->target_amount / $payment) * 100;
        }
            
            else{
             $total=0;   
            }
        } elseif ($save->achievement_id == '3') {
             if($expense > 0){
            $total = ($save->target_amount / $expense) * 100;
             }
            
            else{
             $total=0;   
            }
        } 


                return response()->json(number_format($total,2, '.', ''));                      
 
    }


    public function assign_kpi(Request $request){
        
 	  $dept = $request->user;


        $user=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();
        $goal= GoalTracking::all()->where('user_id', $dept)->where('added_by', auth()->user()->added_by);
        $chk_user=User::find($dept);
       
       
        
          if($request->isMethod('post')){
      $kp=KPI::where('designation_id',$chk_user->designation_id)->first(); 
       $list= KPIList::where('kpi_id',$kp->id)->get();
        }else{
            $list=[];
            $kp='';
        }

       
        return view('performance.assign_kpi',
            compact('dept','user','list','kp','goal'));                
 
    }
    
    
    
     public function save_kpi(Request $request)
    {
        //
       //
         $data = $request->except('goal_id','percent','type','list_id');
        $data['created_by']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

         $kpi=KPIResult::create($data);
         
          $nameArr =$request->type;
          $goalArr =$request->goal_id;
          $inArr = $request->percent  ;
          $listArr =$request->list_id;
          
           if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    
                    if($nameArr[$i] == 'Automatic'){
                      $goal_id= $goalArr[$i]; 
                    }
                    
                    else{
                     $goal_id= '';   
                    }

                    $items = array(
                         'type' => $nameArr[$i],
                        'goal_id' =>  $goal_id,
                        'percent' =>  $inArr[$i],
                        'list_id' => $listArr[$i],
                         'created_by' =>  auth()->user()->id,
                        'added_by' => auth()->user()->added_by,
                        'result_id' =>$kpi->id);
                       
                       KPIResultList::create($items);  ;
    
    
                }
            }

           
        }    
        
       

        return redirect(route('kpi_result'))->with(['success'=>'Created Successfully.']);
        
       

        
    }
    
     public function edit_kpi($id)
    {
        //
        $data=KPIResult::find($id);
       
        $list= KPIList::where('kpi_id',$data->kpi_id)->get();
         $dept = $data->user_id;

        $user=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();
        $goal= GoalTracking::all()->where('user_id', $dept)->where('added_by', auth()->user()->added_by);
        $chk_user=User::find($dept);
        $kp=KPI::where('designation_id',$chk_user->designation_id)->first(); 
     
       
       
        return view('performance.assign_kpi',
            compact('dept','user','list','kp','goal','id','data'));  
    }

public function update_kpi(Request $request, $id)
    {
        //

        $inv=KPIResult::find($id);
        
        $data = $request->except('goal_id','percent','type','list_id','saved_id');
        $data['created_by']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;
         $inv->update($data);
         
        
          $nameArr =$request->type;
          $goalArr =$request->goal_id;
          $inArr = $request->percent  ;
          $listArr =$request->list_id;
          $remArr = $request->removed_id ;
         $expArr = $request->saved_id ;
         
         
         /*
         
          if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    KPIList::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
               
              */ 
              
                if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){

                    if($nameArr[$i] == 'Automatic'){
                      $goal_id= $goalArr[$i]; 
                    }
                    
                    else{
                     $goal_id= '';   
                    }

                    $items = array(
                         'type' => $nameArr[$i],
                        'goal_id' =>  $goal_id,
                        'percent' =>  $inArr[$i],
                        'list_id' => $listArr[$i],
                         'created_by' =>  auth()->user()->id,
                        'added_by' => auth()->user()->added_by,
                        'result_id' =>$id);
                        
                         if(!empty($expArr[$i])){
                               KPIResultList::where('id',$expArr[$i])->update($items);  
          
          }
          else{
                       
                       KPIResultList::create($items);  ;
                       
          }
    
    
                }
            }

           
        }    
        

        return redirect(route('kpi_result'))->with(['success'=>'Updated Successfully.']);
        

    }
    
    
     public function kpi_result(Request $request)
    {
        //
        $list= KPIResult::where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();;
         
       return view('performance.kpi_result',compact('list'));
    }
    
    
      public function close_kpi($id)
    {
        //

        $issue = KPIResult::find($id);
        $issue->update(['active'=> '1']);

        return redirect(route('kpi_result'))->with(['success'=>'Closed Successfully.']);
    }

    public function performance_report(Request $request){
        
 	        $current_month = date('m');
     
            $year= date('Y'); // get current year

            for ($i = 1; $i <= 12; $i++) { // query for months
                if ($i >= 1 && $i <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
                    $month = $year . "-" . '0' . $i;
                } else {
                    $month = $year . "-" . $i;
                }
                $advance_salary_info[$i] = Appraisal::where('appraisal_month',$month)->where('added_by',auth()->user()->added_by)->get();
                
            }
       
      

 return view('performance.performance_report',compact('current_month','year','advance_salary_info'));          
 
    }

  




}
