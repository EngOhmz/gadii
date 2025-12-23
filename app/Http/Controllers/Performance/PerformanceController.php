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
use App\Models\User;
use App\Models\Departments;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list= Indicator::where('added_by',auth()->user()->added_by)->get();;
        $department=Departments::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
       return view('performance.indicator',compact('list','department'));
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
        $data=$request->all();
        $data['created_by']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

         Indicator::create($data);
        
       

        return redirect(route('indicator.index'))->with(['success'=>'Created Successfully.']);
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
        $data=Indicator::find($id);
         $department=Departments::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();

       return view('performance.indicator',compact('department','data','id'));
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

        $inv=Indicator::find($id);
        
        
         $data=$request->all();
         $inv->update($data);
        

        return redirect(route('indicator.index'))->with(['success'=>'Updated Successfully.']);
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

        $issue = Indicator::find($id);
        $issue->delete();

        return redirect(route('indicator.index'))->with(['success'=>'Deleted Successfully.']);
    }
    
    public function checkDepartment(Request $request){
        
         
$dep=$request->id;
$chk=$request->check;

if(!empty($chk)){
$before= Indicator::find($chk); 

if($dep == $before->department_id){
$price='' ;    
}

else{
$data=Indicator::where('department_id',$dep)->first();

if(!empty($data)){
$price="Indicator has already been set for this department" ;
}

else{
$price='' ;
 }
 
}  
  
    
}

else{
    
$data=Indicator::where('department_id',$dep)->first();

if(!empty($data)){
$price="Indicator has already been set for this department" ;
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


 if (!empty($chk_user->department_id)) {
     
$dep=Departments::find($chk_user->department_id);
$chk_dep=Indicator::where('department_id',$chk_user->department_id)->first();

if (empty($chk_dep)){
$price="Please set indicator for user's Department. The Department is  ".  $dep->name ;

}
else{
$price='' ;
 }


}
else{
$price="You can not give appraisal . Please set department for the User ".  $chk_user->name ;
}



                return response()->json($price);                      
 
    }

 public function findMonth(Request $request)
    {
 
$user_id=$request->user;
$month=$request->id;

 $list= Appraisal::where('user_id', $user_id)->where('appraisal_month', $month)->where('added_by',auth()->user()->added_by)->first();

  if(!empty($list)){
    $price='Appraisal Information Already provided to this user for '.date('F Y', strtotime($month)); 
                           }
else{
$price='';    
     }

                return response()->json($price);                      
 
    }

     public function appraisal(Request $request){
        
 	  $dept = $request->user;
        $month = $request->month;

        $user=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();
        $chk_user=User::find($dept);
        
          if($request->isMethod('post')){
       $list= Indicator::where('department_id',$chk_user->department_id)->first();
        }else{
            $list=[];
        }

       
        return view('performance.appraisal',
            compact('dept','month','user','list'));                
 
    }
    
     public function save_appraisal(Request $request)
    {
        //
        $data=$request->all();
        $data['created_by']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        Appraisal::create($data);
        
       

        return redirect(route('performance_report'))->with(['success'=>'Created Successfully.']);
    }
    
     public function edit_appraisal($id)
    {
        //
        $data= Appraisal::find($id);
         $department=Departments::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
         
           $dept = $data->user_id;
          $month = $data->appraisal_month;

        $user=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();
        $chk_user=User::find($dept);
        
       $list= Indicator::where('department_id',$chk_user->department_id)->first();

       return view('performance.appraisal',compact('department','data','id','dept','month','user','list'));
    }

public function update_appraisal(Request $request, $id)
    {
        //

        $inv=Appraisal::find($id);
        
        
         $data=$request->all();
         $inv->update($data);
        

        return redirect(route('performance_report'))->with(['success'=>'Updated Successfully.']);
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

  

public function discountModal(Request $request)
{
             $id=$request->id;
             $type = $request->type;
              if($type == 'view'){
                $data=Indicator::find($id);
                return view('performance.indicator_details',compact('id','data'));
  }
  
   else if($type == 'view-performance'){
                $data=Appraisal::find($id);
                 $dept = $data->user_id;
                $chk_user=User::find($dept);
                 $list= Indicator::where('department_id',$chk_user->department_id)->first();
                return view('performance.appraisal_details',compact('id','data','list'));
  }
  
   else if($type == 'view-kpi'){
                   $list=KPI::find($id);
                $data=KPIList::where('kpi_id',$id)->get();
                return view('performance.kpi_details',compact('id','data','list'));
  }
  
  else if($type == 'addgoal'){
      $user_id=$request->user;
                  $achv = Achievement::all();
        $user=User::where('added_by',auth()->user()->added_by)->where('disabled',0)->get();
                return view('performance.add_goal',compact('id','achv','user','user_id'));
  }
  
   else if($type == 'view-result'){
                   $list=KPIResult::find($id);
                $data=KPIResultList::where('result_id',$id)->get();
                return view('performance.kpi_result_details',compact('id','data','list'));
  }

             }
             
             
             

}
