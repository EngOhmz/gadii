<?php

namespace App\Imports;

use App\Models\JournalEntry2 ;
use App\Models\AccountCodes ;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class CheckJournalEntry  implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   $contains = Str::contains($row[1], 'CREDIT');
        if(!$contains){
            
        $account = AccountCodes::where('account_name',$row[0])->get()->first()->account_codes;
            if(count($account) > 0){
        return new JournalEntry([
        'gl_code' => AccountCodes::where('account_name',$row[0])->get()->first()->account_codes,
        'account_id' => AccountCodes::where('account_name',$row[0])->get()->first()->account_id,
        'month' => date('m',strtotime($row[3])),
        'year' =>  date('y',strtotime($row[3])),
        'date' => $row[3],
        'credit' => $row[1],
        'debit' => $row[2],
        ]);
        
            }
            else{
                return redirect(route())
            }
        }
    }
}
