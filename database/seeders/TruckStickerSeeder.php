<?php

namespace Database\Seeders;

use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Sticker;
use App\Models\Truck;
use Illuminate\Database\Seeder;

class TruckStickerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data= [
            [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 127 DWW')->first()->id,
                'added_by' => '57',
    
              ],

              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 183 DWW')->first()->id,
                'added_by' => '57',
              ],
              [
                
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 898 DYL')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 187 DWW')->first()->id,
                'added_by' => '57',
              ],
              [
                
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 344 DWW')->first()->id,
                'added_by' => '57',
              ],
              [   
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 350 DWW')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 352 DWW')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 737 DWZ')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 738 DWZ')->first()->id,
                'added_by' => '57',
              ],
              [
                
                'issue_date' => date('Y-m-d',strtotime('09/02/21')),
                'expire_date' => date('Y-m-d',strtotime('09/01/22')),
                'truck_id' => Truck::where('reg_no','T 739 DWZ')->first()->id,
                'added_by' => '57',
              ],

              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 174 DVH')->first()->id,
                'added_by' => '57',
    
              ],

              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 163 DVH')->first()->id,
                'added_by' => '57',
              ],
              [
                
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 169 DVH')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 485 DVR')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 168 DVH')->first()->id,
                'added_by' => '57',
              ],
              [  
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 723 DVK')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 484 DVR')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 176 DVH')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 481 DVR')->first()->id,
                'added_by' => '57',
              ],
              [
                'issue_date' => date('Y-m-d',strtotime('08/27/21')),
                'expire_date' => date('Y-m-d',strtotime('08/26/22')),
                'truck_id' => Truck::where('reg_no','T 483 DVR')->first()->id,
                'added_by' => '57',
              ],
            ];
    
            foreach ($data as $row) {
                $truck=Sticker::create($row);

$supp=Truck::find($truck->truck_id);
 
$dr= AccountCodes::where('account_name','LATRA STICKER')->first();
$journal = new JournalEntry();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->created_at);
  $journal->date =   $truck->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_sticker';
  $journal->name = 'Truck LATRA STICKER';
  $journal->debit = '0';
  $journal->payment_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
  $journal->added_by='57';
  $journal->notes= "Truck LATRA STICKER for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();



  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->created_at);
  $journal->date =   $truck->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_sticker';
  $journal->name = 'Truck LATRA STICKER';
  $journal->credit = '0';
  $journal->payment_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
  $journal->added_by='57';
  $journal->notes= "Truck LATRA STICKER for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();
 
            }
    }
}
