<?php

namespace App\Imports;

use App\Models\AccountCodes;
use App\Models\JournalEntry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Location;
use App\Models\POS\Activity;
use App\Models\POS\Items;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\SerialList;
use App\Models\POS\Category;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use DB;

class ImportItems implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    //, WithValidation
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row['type'] == 'Inventory') {
                $type = 1;
            }

            if ($row['type'] == 'Service') {
                $type = 4;
            }

            if ($row['tax_rate'] == '18%') {
                $tax = 0.18;
            } elseif ($row['tax_rate'] != '18%') {
                $tax = 0;
            }

            $cd = Category::where('added_by', auth()->user()->added_by)
                ->where('name', $row['category'])
                ->first();

            if (!empty($cd)) {
                $category = $cd->id;
            } else {
                $category = '';
            }

            $old = Items::where(DB::raw('lower(name)'), strtolower($row['name']))
                ->where('added_by', auth()->user()->added_by)
                ->where('disabled', '0')
                ->first();

            if (empty($old)) {
                $a = Items::create([
                    'name' => $row['name'],
                    'cost_price' => $row['cost_price'],
                    'sales_price' => $row['sales_price'],
                    'quantity' => $row['quantity'],
                    'unit' => $row['unit'],
                    'bar_code' => $row['bar_code'],
                    'description' => $row['description'],
                    'type' => $type,
                    'category_id' => $category,
                    'tax_rate' => $tax,
                    'added_by' => auth()->user()->added_by,
                ]);

                if (!empty($a)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'module_id' => $a->id,
                        'module' => 'Inventory',
                        'activity' => 'Inventory ' . $a->name . ' is Created',
                    ]);
                }
                $c = $a->id;
            } else {
                Items::find($old->id)->update([
                    'quantity' => $old->quantity + $row['quantity'],
                ]);

                $b = Items::find($old->id);

                if (!empty($b)) {
                    $activity = Activity::create([
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'module_id' => $b->id,
                        'module' => 'Inventory',
                        'activity' => 'Inventory ' . $b->name . ' is Updated',
                    ]);
                }
                $c = $old->id;
            }

            $item = Items::find($c);

            if (!empty($item)) {
                //dd($today);
                //$new= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($today)->format('Y-m-d');

                if (!empty($row['date'])) {
                    $today = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
                    $date = explode('-', $today);
                } else {
                    $today = date('Y-m-d');
                    $date = explode('-', $today);
                }

                $nameArr = $row['quantity'];
                if ($nameArr > 0) {
                    if ($row['balance'] > 0) {
                        $drjournal = JournalEntry::create([
                            'account_id' => AccountCodes::where('account_name', 'Inventory')
                                ->where('added_by', auth()->user()->added_by)
                                ->get()
                                ->first()->id,
                            'date' => $today,
                            'month' => $date[1],
                            'year' => $date[0],
                            'credit' => '0',
                            'debit' => $row['balance'],
                            'income_id' => $item->id,
                            'name' => 'POS Items',
                            'transaction_type' => 'import_pos_items',
                            'notes' => 'POS Item Balance for ' . $row['name'],
                            'added_by' => auth()->user()->added_by,
                        ]);

                        $crjournal = JournalEntry::create([
                            'account_id' => AccountCodes::where('account_name', 'Open Balance')
                                ->where('added_by', auth()->user()->added_by)
                                ->get()
                                ->first()->id,
                            'date' => $today,
                            'month' => $date[1],
                            'year' => $date[0],
                            'credit' => $row['balance'],
                            'debit' => '0',
                            'income_id' => $item->id,
                            'name' => 'POS Items',
                            'transaction_type' => 'import_pos_items',
                            'notes' => 'POS Item Balance for ' . $row['name'],
                            'added_by' => auth()->user()->added_by,
                        ]);
                    }

                    $lists = [
                        'quantity' => $nameArr,
                        'price' => $row['cost_price'],
                        'item_id' => $item->id,
                        'added_by' => auth()->user()->added_by,
                        'user_id' => auth()->user()->id,
                        'purchase_date' => $today,
                        'location' => Location::where(DB::raw('lower(name)'), strtolower($row['location']))
                            ->where('added_by', auth()->user()->added_by)
                            ->get()
                            ->first()->id,
                        'type' => 'Purchases',
                    ];

                    PurchaseHistory::create($lists);

                    if ($nameArr > 0) {
                        $mlists = [
                            'in' => $nameArr,
                            'price' => $row['cost_price'],
                            'item_id' => $item->id,
                            'added_by' => auth()->user()->added_by,
                            'location' => Location::where(DB::raw('lower(name)'), strtolower($row['location']))
                                ->where('added_by', auth()->user()->added_by)
                                ->get()
                                ->first()->id,
                            'date' => $today,
                            'type' => 'Purchases',
                        ];
                    } else {
                        $mlists = [
                            'out' => abs($nameArr),
                            'price' => $row['cost_price'],
                            'item_id' => $item->id,
                            'added_by' => auth()->user()->added_by,
                            'location' => Location::where('name', $row['location'])
                                ->where('added_by', auth()->user()->added_by)
                                ->get()
                                ->first()->id,
                            'date' => $today,
                            'type' => 'Purchases',
                        ];
                    }

                    MasterHistory::create($mlists);

                    $loc = Location::where('name', $row['location'])
                        ->where('added_by', auth()->user()->added_by)
                        ->first();
                    $lq['quantity'] = $loc->quantity + $nameArr;
                    Location::where('name', $row['location'])
                        ->where('added_by', auth()->user()->added_by)
                        ->update($lq);

                    $random = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4 / strlen($x)))), 1, 4);

                    /*
                          
                            if(auth()->user()->added_by == '619'){
                        
                         for($x = 0.25; $x <= $nameArr; $x+=0.25){
                $name=Items::where('id', $item->id)->first();

                    if($name->bar == '1'){
                    $due=1 * $name->bottle;
                    }

                    else{
                    $due=1 ;
                    }
              
                        $series = array(
                            'serial_no' => $random."-".$x,
                            'bar' => $name->bar,
                            'brand_id' => $item->id,
                            'added_by' => auth()->user()->added_by,
                            'purchase_date' =>   $today,
                            'location' =>  Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'quantity' =>  1,
                            'due_quantity' =>  $due,
                            'source_store' => Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'crate_status' => '0',
                            'status' => '0');
                       
                    
                  SerialList::create($series);
                  
                  
                   
                    }
                    
                            }
                            
                            else{
                                
                                               for($x = 1; $x <= $nameArr; $x++){
                $name=Items::where('id', $item->id)->first();

                    if($name->bar == '1'){
                    $due=1 * $name->bottle;
                    }

                    else{
                    $due=1 ;
                    }
              
                        $series = array(
                            'serial_no' => $random."-".$x,
                            'bar' => $name->bar,
                            'brand_id' => $item->id,
                            'added_by' => auth()->user()->added_by,
                            'purchase_date' =>   $today,
                            'location' =>  Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'quantity' =>  1,
                            'due_quantity' =>  $due,
                            'source_store' => Location::where('name',$row['location'])->where('added_by',auth()->user()->added_by)->get()->first()->id,
                            'crate_status' => '0',
                            'status' => '0');
                       
                    
                  SerialList::create($series);
                  
                  
                   
                    }
                    
                    */
                }
            }
        }
    }
}

