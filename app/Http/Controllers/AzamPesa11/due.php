 if($purchase->day <= $year && $year < $purchase->month ){
            $x=$year/$purchase->day;
            
            $due_date=floor($x);;

                
                $now = Carbon::now();             
                $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                $xx=$due_date.' days';;
                 //dd($xx);
                 
       
        }
        
        else if($purchase->month <= $year && $year < $purchase->year ){
            $x=$year/$purchase->month;
            $due_date=ceil($x * 30.436875);
            
       $y=0;
       
        $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) ;)
		$m = floor($m); // Remove

		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
	    $d = floor($d); // the rest of days
        
        if($m > 0 && $d > 0){
		$xx=$m.' months and '.$d.' days';
        }
        else if($m > 0 && $d== 0){
          $xx=$m.' months';  
        }
             
             
                                      
                    $now = Carbon::now();
                    
               $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                 //dd($xx);
                
        }
        
        
         elseif($year >= $purchase->year ){
             
           $x=$year/$purchase->year;
            $ii=floor($x);
            $rem=$year - ($ii * $purchase->year);
            
            $nd=0;
           
            if($rem > 0){
                
            if($purchase->day <= $rem && $rem < $purchase->month ){
            $rx=$rem/$purchase->day;
            $nd=floor($rx);
        }
        
        elseif($purchase->month <= $rem && $rem < $purchase->year ){
            $rx=$rem/$purchase->month;
            $nd=ceil($rx * 30.436875);
           
                
        } 
            
               
            }
            
            
         
          
        $due_date=($ii * 365) + $nd;
        
        $y = ($due_date / 365) ; // days / 365 days
		$y = floor($y); // Remove all decimals
            
       $m =(($due_date - ($y * 365))/30.5); // I choose 30.5 for Month (30,31) ;)
		$m = floor($m); // Remove

		$d =  ($due_date - ($y * 365) - ($m * 30.5)); 
		$d = floor($d); // the rest of days

        if($y > 0 && $m > 0 && $d > 0){
        $xx= $y.' years , '.$m.' months and '.$d.' days';
        }
        else if($y > 0 && $m == 0 && $d > 0){
		$xx=$y.' years and '.$d.' days';
        }
        else if($y > 0 && $m > 0 && $d == 0){
		$xx=$y.' years and '.$m.' months';
        }
       else if($y > 0 && $m == 0 && $d == 0){
          $xx=$y.' years';  
        }
                                        
                    $now = Carbon::now();
                    
               $due_dateNew=date('Y-m-d', strtotime("+$due_date days", strtotime($now)));
                 //dd($xx);
                
        }
        
        
        
                 $dlist['user_id']=1;
                 $dlist['role_id']=1;
                 $dlist['old_date']=$now;
                 $dlist['new_date']=$due_dateNew;
                 $dlist['deposit_id']=1;
                 $dlist['duration']=$xx;
                 $dlist['added_by']=auth()->user()->added_by;
                 dd($dlist);
        DueDate::create( $dlist);