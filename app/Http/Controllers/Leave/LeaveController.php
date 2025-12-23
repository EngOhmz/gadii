<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\Leave\Leave;
use App\Models\Leave\LeaveCategory;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Expenses;
use DB;
use DateTime;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF; 

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = LeaveCategory::where('added_by',auth()->user()->added_by)->get(); 
        $staff=User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();    
        $leave = Leave::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();   
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('leave.leave',compact('category','staff','leave','bank_accounts'));
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
    // public function store(Request $request)
    // {
    //     //
    //     $data = $request->all();
    //     $data['added_by']=auth()->user()->added_by;
    //     $data['application_status']='1';
        
        
    //     $start = strtotime($request->leave_start_date);
    //     if(!empty($request->leave_end_date)){
    //       $end = strtotime($request->leave_start_date);
    //       $days_between = ceil(abs($end - $start) / 86400);
    //     }else{
    //       $days_between = 1;
    //     }
        
        
    //      // If leave_end_date is empty, set it to leave_start_date
    //     $start = strtotime($request->leave_start_date);
    //     if (empty($request->leave_end_date)) {
    //         $request->leave_end_date = $request->leave_start_date;
    //     }
        
    //     $end = strtotime($request->leave_end_date);
    //     $days_between = ceil(abs($end - $start) / 86400);


    //     $data['days'] = $days_between;

    //     if ($request->hasFile('attachment')) {
    //         $file=$request->file('attachment');
    //         $fileType=$file->getClientOriginalExtension();
    //         $fileName=rand(1,1000).date('dmyhis').".".$fileType;
    //         $name=$fileName;
    //         $path = public_path(). "/assets/files/leave";
    //         $file->move($path, $fileName );
            
    //         $data['attachment'] = $name;
    //     }else{
    //         $data['attachment'] = null;
    //     }
        
    //     $leave= Leave::create($data);
 
    //     return redirect(route('leave.index'))->with(['success'=>'Leave Created Successfully']);
    // }
    
    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['added_by'] = auth()->user()->added_by;
        $data['application_status'] = '1';
    
        if (empty($request->leave_end_date)) {
            $data['leave_end_date'] = $request->leave_start_date; // Store it in the $data array
        } else {
            $data['leave_end_date'] = $request->leave_end_date;
        }
    
        $start = strtotime($data['leave_start_date']);
        $end = strtotime($data['leave_end_date']);
        
        $days_between = ceil(abs($end - $start) / 86400);
        $data['days'] = $days_between;
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileType = $file->getClientOriginalExtension();
            $fileName = rand(1, 1000) . date('dmyhis') . "." . $fileType;
            $path = public_path() . "/assets/files/leave";
            $file->move($path, $fileName);
            $data['attachment'] = $fileName;
        } else {
            $data['attachment'] = null;
        }
        
        if(!empty($request->start_hour)){
           $data['start_hour'] = date('H:i:s', strtotime($request->start_hour));
           $data['end_hour'] = date('H:i:s', strtotime($request->end_hour)); 
        }
        

        $leave = Leave::create($data);
    
        return redirect(route('leave.index'))->with(['success' => 'Leave Created Successfully']);
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

    public function discountModal(Request $request)
    {
               

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
        $data =  Leave::find($id);
        $category = LeaveCategory::where('added_by',auth()->user()->added_by)->get(); 
        $staff=User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();    
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        
        return view('leave.leave',compact('category','staff','data','id','bank_accounts'));
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
        $leave=  Leave::find($id);

        $data = $request->all();
        $data['added_by']=auth()->user()->added_by;

        if ($request->hasFile('attachment')) {
            $file=$request->file('attachment');
            $fileType=$file->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $name=$fileName;
            $path = public_path(). "/assets/files/leave";
            $file->move($path, $fileName );
            
            $data['attachment'] = $name;
        }else{
                $data['attachment'] = null;
        }

                

        // $start = strtotime($request->leave_start_date);
        //   if(!empty($request->leave_end_date)){
        //   $end = strtotime($request->leave_start_date);
        //   $days_between = ceil(abs($end - $start) / 86400);
        //   }
        //   else{
        //   $days_between = 1;
        //   }

        // $data['days'] = $days_between;
        
        
        
        if (empty($request->leave_end_date)) {
            $data['leave_end_date'] = $request->leave_start_date; // Store it in the $data array
        } else {
            $data['leave_end_date'] = $request->leave_end_date;
        }
    
        $start = strtotime($data['leave_start_date']);
        $end = strtotime($data['leave_end_date']);
        
        $days_between = ceil(abs($end - $start) / 86400);
        $data['days'] = $days_between;
        
        // Convert AM/PM time to 24-hour format (HH:mm:ss)
        if(!empty($request->start_hour)){
           $data['start_hour'] = date('H:i:s', strtotime($request->start_hour));
        $data['end_hour'] = date('H:i:s', strtotime($request->end_hour));
        }
        
        $leave->update($data);
        
        return redirect(route('leave.index'))->with(['success'=>'Leave Updated Successfully']);

       
        
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
         $leave=  Leave::find($id);
        $leave->delete();
        
          return redirect(route('leave.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function category(Request $request)
    {
        //
        $data = $request->all();
        $data['added_by']=auth()->user()->added_by;
        $category =LeaveCategory::create($data);
       
       if ($request->ajax()) {

            return response()->json($category);
       }
    }
    
    
     public function findDays(Request $request)
    {
        //
          $start = strtotime($request->id);
          if(!empty($request->date)){
          $end = strtotime($request->date);
           $days_between = ceil(abs($end - $start) / 86400);
          }
          else{
          $days_between = 1;
          }
         
          
          //dd($days_between);
          
        $start_year=date('Y-m-d', strtotime('first day of january this year'));
        $end_year=date('Y-m-d', strtotime('last day of december this year'));
            
        $category =LeaveCategory::find($request->category);
         if(strtolower($category->leave_category) == 'annual leave'){
            $user=User::find($request->user);
           
           if($user->leave_balance < $days_between ){
              $data='You have exceeded your days of leave. You are left with '.  $user->leave_balance.' days';  
           }
           else{
             $data='';    
           }
           
        }
        
        else{
             if($category->limitation == 'Yes'){
                 
                $leave= Leave::where('staff_id',$request->user)->where('leave_category_id',$request->category)->where('application_status',2)->whereBetween('leave_start_date',[$start_year,$end_year])->whereBetween('leave_end_date',[$start_year,$end_year])->sum('days');
                $balance= $category->days - $leave ;
             
              if($balance < $days_between ){
              $data='You have exceeded your days of leave. You are left with '.  $balance.' days';  
           }
           
           else{
             $data='';    
           }
             
             
             }
             
             else{
                $data='';    
             }
        }
       
  
            return response()->json($data);
       
    }
    
    
      public function findPaid(Request $request)
    {
        //
        $category =LeaveCategory::find($request->id);
        if($category->paid == 'Yes'){
            $data='Yes';
        }
       
    else{
          $data='';
    }
            return response()->json($data);
       
    }

    public function approve($id)
    {
        //
        // $leave = Leave::find($id);
        // $data['application_status'] = 2;
        // $data['approve_by'] = auth()->user()->id;
        // $leave->update($data);
        
        $leave = Leave::find($id);
        $currentStatus = $leave->application_status;
        
        // Handle rejection scenario first (status 5)
        // if ($currentStatus == 1 || $currentStatus == 2 || $currentStatus == 3) {
        //     if (auth()->user()->can('leave-reject')) {
        //         $data['application_status'] = 5; // Rejected
        //     }
        // } 
        
        if ($currentStatus == 1 && auth()->user()->can('leave-first-approve')) {
            $data['application_status'] = 2; // First Level Approved
        } elseif ($currentStatus == 2 && auth()->user()->can('leave-second-approve')) {
            $data['application_status'] = 3; // Second Level Approved
        } elseif ($currentStatus == 3 && auth()->user()->can('leave-third-approve')) {
            $data['application_status'] = 4; // Third Level Approved (Final Approval)
        } elseif ($currentStatus == 1 && auth()->user()->can('leave-third-approve')) {
            $data['application_status'] = 4; // Third Level Approved (Final Approval)
        } elseif ($currentStatus == 2 && auth()->user()->can('leave-third-approve')) {
            $data['application_status'] = 4; // Third Level Approved (Final Approval)
        } else {
            return redirect()->back()->with('error', 'You do not have permission to approve or reject this leave.');
        }
        
        $data['approve_by'] = auth()->user()->id;
        $leave->update($data);


        
        $user=User::find($leave->staff_id);
        
          $category =LeaveCategory::find($leave->leave_category_id);
         if(strtolower($category->leave_category) == 'annual leave'){
            
              $start = strtotime($leave->leave_start_date);
          if(!empty($leave->leave_end_date)){
          $end = strtotime($leave->leave_end_date);
           $days_between = ceil(abs($end - $start) / 86400);
          }
          else{
          $days_between = 1;
          }
          
          $balance=$user->leave_balance - $days_between;
             User::find($leave->staff_id)->update(['leave_balance' =>$balance ]); 
        }
        
        
        if(!empty($leave->amount)){
           
            
             if($leave->pay_type == 'Cash'){
                 
            $cr= AccountCodes::where('account_name','Leave Control Account')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$leave->leave_start_date);
          $journal->date =   $leave->leave_start_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'leave';
          $journal->name = 'Leave';
          $journal->debit = $leave->amount;
          $journal->income_id= $leave->id;
           $journal->user_id= $leave->staff_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Leave on Cash to user  ". $user->name ;
          $journal->save();
          
           $journal = new JournalEntry();
           $codes= AccountCodes::where('account_name','Staff Leave')->where('added_by', auth()->user()->added_by)->first();
          $journal->account_id =$codes->id;
         $date = explode('-',$leave->leave_start_date);
          $journal->date =   $leave->leave_start_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'leave';
          $journal->name = 'Leave';
          $journal->credit = $leave->amount;
          $journal->income_id= $leave->id;
           $journal->user_id= $leave->staff_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Leave on Cash to user  ". $user->name ;
          $journal->save();
          
          
           $journal = new JournalEntry();
          $codes= AccountCodes::where('account_name','Staff Leave')->where('added_by', auth()->user()->added_by)->first();
          $journal->account_id =$codes->id;
         $date = explode('-',$leave->leave_start_date);
          $journal->date =   $leave->leave_start_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'leave';
          $journal->name = 'Paid Leave';
          $journal->debit = $leave->amount;
          $journal->income_id= $leave->id;
           $journal->user_id= $leave->staff_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Paid Leave on Cash to user  ". $user->name ;
          $journal->save();
        

          $journal = new JournalEntry();
          $journal->account_id =$leave->bank_id;
         $date = explode('-',$leave->leave_start_date);
          $journal->date =   $leave->leave_start_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'leave';
          $journal->name = 'Paid Leave';
          $journal->credit = $leave->amount;
          $journal->income_id= $leave->id;
           $journal->user_id= $leave->staff_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Paid Leave on Cash to user  ". $user->name ;
          $journal->save();
    
            
        }
        
        else{
            
             $cr= AccountCodes::where('account_name','Leave Control Account')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$leave->leave_start_date);
          $journal->date =   $leave->leave_start_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'leave';
          $journal->name = 'Leave';
          $journal->debit = $leave->amount;
          $journal->income_id= $leave->id;
           $journal->user_id= $leave->staff_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Leave on Cash to user  ". $user->name ;
          $journal->save();
          
           $journal = new JournalEntry();
           $codes= AccountCodes::where('account_name','Staff Leave')->where('added_by', auth()->user()->added_by)->first();
          $journal->account_id =$codes->id;
         $date = explode('-',$leave->leave_start_date);
          $journal->date =   $leave->leave_start_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'leave';
          $journal->name = 'Leave';
          $journal->credit = $leave->amount;
          $journal->income_id= $leave->id;
           $journal->user_id= $leave->staff_id;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Leave on Cash to user  ". $user->name ;
          $journal->save();
          
            
        }
        
        
        }    
        
        
        return redirect(route('leave.index'))->with(['success'=>'Approved Successfully']);
    }

     public function reject($id)
    {
        //
        $leave = Leave::find($id);
        $data['application_status'] = 5;
        $leave->update($data);
        return redirect(route('leave.index'))->with(['success'=>'Rejected Successfully']);
    }
    
    
   public function leave_report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
                
        $added_by = auth()->user()->added_by;
        
        // Ensure start and end dates are properly formatted
        if (!empty($start_date)) {
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
        
            $leave = DB::table('tbl_leave_application')
                        ->join('tbl_leave_category', 'tbl_leave_category.id', '=', 'tbl_leave_application.leave_category_id')
                        ->leftJoin('users', 'users.id', '=', 'tbl_leave_application.staff_id')
                        ->select(
                            'tbl_leave_category.leave_category',
                            'tbl_leave_application.days',
                            'users.name as staff',
                            'users.id as staff_id',
                            DB::raw("SUM(CASE WHEN tbl_leave_application.leave_start_date >= '{$start_date}' AND tbl_leave_application.leave_end_date <= '{$end_date}' THEN tbl_leave_application.days ELSE 0 END) AS no_days"),
                            DB::raw("SUM(CASE WHEN tbl_leave_application.leave_start_date >= '{$start_date}' AND tbl_leave_application.leave_end_date <= '{$end_date}' THEN tbl_leave_application.hours ELSE 0 END) AS no_hours"),
                            DB::raw("COUNT(CASE WHEN tbl_leave_application.leave_start_date >= '{$start_date}' AND tbl_leave_application.leave_end_date <= '{$end_date}' THEN 1 END) AS leave_count")
                       
                        )
                ->where('tbl_leave_application.disabled', 0)
                ->where('tbl_leave_application.added_by', $added_by)
                ->groupBy('tbl_leave_application.staff_id')
                ->get();
        
            return view('pos.report.leave_report', compact('start_date', 'end_date', 'leave'));
        } else {
            return view('pos.report.leave_report', compact('start_date', 'end_date'));
        }

        
    }

    
  

    public function generateLeaveReport(Request $request)
    {
        // Retrieve query parameters
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $staff_id = $request->staff_id;  // Staff ID for individual reports
    
        $query = Leave::query();
    
        if ($start_date && $end_date) {
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->whereBetween('leave_start_date', [$start_date, $end_date])
                  ->orWhereBetween('leave_end_date', [$start_date, $end_date])
                  ->orWhere(function ($q2) use ($start_date, $end_date) {
                      $q2->where('leave_start_date', '<=', $start_date)
                         ->where('leave_end_date', '>=', $end_date);
                  });
            });
        }
    
        if ($staff_id) {
            $query->where('staff_id', $staff_id);
        }
    
        $leaves = $query->with('staff')  // Assuming Leave has an `staff` relationship
            ->where('disabled', 0)
            ->orderBy('leave_start_date', 'ASC')
            ->get();
    
        foreach ($leaves as $leave) {
            if ($leave->leave_type === 'hours') {
                $leave->duration = $leave->hours;  // Assuming `hours` field stores the number of hours
                $leave->duration_type = 'hours';
            } else {
                $leave->duration = \Carbon\Carbon::parse($leave->leave_start_date)->diffInDays($leave->leave_end_date) + 1;
                $leave->duration_type = 'days';
            }
        }
    
        $pdf = PDF::loadView('pos.report.leave_report_pdf', compact('leaves', 'start_date', 'end_date', 'staff_id'));
    
        return $pdf->download('leave_report_' . $staff_id . '.pdf');
    }


}
