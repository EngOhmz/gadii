<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School\School;
use App\Models\School\SchoolDetails;
use App\Models\School\SchoolBreakdown;
use App\Models\School\SchoolLevel;
use App\Models\AccountCodes;
use App\Models\GroupAccount;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $schools = School::where('added_by',auth()->user()->added_by)->get();
           $level=SchoolLevel::groupBy('level')->get();;
            $branch = Branch::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
            $group=AccountCodes::leftJoin('gl_account_group', 'gl_account_codes.account_group','gl_account_group.id')
                          ->where('gl_account_codes.disabled','0')
                          ->where('gl_account_codes.added_by',auth()->user()->added_by)
                           ->where('gl_account_group.name','School')     
                           ->select('gl_account_codes.*')
                              ->get()  ;
        return view('raja.school.home',compact('schools','level','group','branch'));
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

        if(!empty($request->level) && !empty($request->type)){
          $school=School::create([
          'branch_id' =>$request->branch_id ,
          'feeType' =>$request->feeType ,
          'price' =>str_replace(",","",$request->price),
           'added_by'=>auth()->user()->added_by,
]);


  $nameArr =$request->level ;
 $classArr = $request->class  ;
$typeArr =$request->type ;
 $amountArr = $request->amount  ;

    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
               $sch_class=SchoolLevel::where('id',$classArr[$i])->first();
                $items = array(
                    'level' => $nameArr[$i],
                    'branch_id' =>$request->branch_id ,
                    'class' =>   $sch_class->class,
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'fee_id' =>$school->id);

                SchoolDetails::create($items);  ;


            }
        }
    }   

if(!empty($typeArr)){
        for($i = 0; $i < count($typeArr); $i++){
            if(!empty($typeArr[$i])){
                $list = array(
                    'type' => $typeArr[$i],
                    'amount' =>   $amountArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'fee_id' =>$school->id);

                SchoolBreakdown::create($list);  ;


            }
        }
    } 
 
            
  }

else{
 return redirect()->route('school.index')->with('error', 'Please Enter the Classes/Type');
}         

   
            return redirect()->route('school.index')->with('success', 'Saved Successfully');
   
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
        $school = School::find($id);
        $rows = SchoolDetails::where('fee_id',$id)->get();
        return view('raja.school.show', compact('school', 'rows'));
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
      //$rows = DB::table('schools')->select('feeType', 'price')->where('id', $id)->get();
        // $rows = School::where('id', $id)->get();

        $school = School::find($id);        
         $level=SchoolLevel::groupBy('level')->get();;
         $items = SchoolDetails::where('fee_id',$id)->get();
        $type=SchoolBreakdown::where('fee_id',$id)->get();
         $branch = Branch::where('disabled', '0')
            ->where('added_by', auth()->user()->added_by)
            ->get();
     $group=AccountCodes::leftJoin('gl_account_group', 'gl_account_codes.account_group','gl_account_group.id')
                          ->where('gl_account_codes.disabled','0')
                          ->where('gl_account_codes.added_by',auth()->user()->added_by)
                           ->where('gl_account_group.name','School')     
                           ->select('gl_account_codes.*')
                              ->get()  ;
         return view('raja.school.home',compact('school','level','id','items','group','type','branch'));
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

      $school= School::find($id);

        if(!empty($request->level)){
          School::where('id',$id)->update([
          'feeType' =>$request->feeType ,
          'branch_id' =>$request->branch_id ,
          'price' =>str_replace(",","",$request->price) ,
           'added_by'=>auth()->user()->added_by,
]);


  $nameArr =$request->level ;
 $classArr = $request->class  ;
 $typeArr =$request->type ;
 $amountArr = $request->amount  ;
 $remArr = $request->removed_id ;
  $expArr = $request->details ;
 $tremArr = $request->tremoved_id ;
  $texpArr = $request->type_id ;

 if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                   SchoolDetails::where('id',$remArr[$i])->delete();        
                   }
               }
           }


    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
               $sch_class=SchoolLevel::where('id',$classArr[$i])->first();
                $items = array(
                    'level' => $nameArr[$i],
                    'branch_id' =>$request->branch_id ,
                    'class' =>   $sch_class->class,
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'fee_id' =>$id);

                    if(!empty($expArr[$i])){
                            SchoolDetails::where('id',$expArr[$i])->update($items);  
      
      }
                          else{
                           SchoolDetails::create($items);  ; 
      
      }

              
            }
        }
    } 


 if (!empty($tremArr)) {
            for($i = 0; $i < count($tremArr); $i++){
               if(!empty($tremArr[$i])){        
                    SchoolBreakdown::where('id',$tremArr[$i])->delete();        
                   }
               }
           }


    if(!empty($typeArr)){
        for($i = 0; $i < count($typeArr); $i++){
            if(!empty($typeArr[$i])){
                $list = array(
                    'type' => $typeArr[$i],
                    'amount' =>   $amountArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'fee_id' =>$id);

                    if(!empty($texpArr[$i])){
                           SchoolBreakdown::where('id',$texpArr[$i])->update($list);  
      
      }
                          else{
                            SchoolBreakdown::create($list);  ;
      
      }

              
            }
        }
    } 

   
            
  }

else{
 return redirect()->route('school.index')->with('error', 'Please Enter the Classes/Type');
}         


   
        return redirect()->route('school.index')->with('success', 'Updated Successfully');
   
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
        SchoolDetails::where('fee_id', $id)->delete();
        $school =  School::find($id);
       $school->delete();

        return redirect()->route('school.index')->with('success', 'Deleted Successfully');
   
    }
}
