<?php

namespace App\Http\Controllers\Api_controllers\Pms\POS;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Restaurant\POS\Menu;
use App\Models\Restaurant\POS\MenuComponent;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;


class MenuItemController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        //   $index=Menu::where('user_id',auth()->user()->added_by)->get();;
        //   $type="";
        //     return view('restaurant.menu-item.index', compact('index','type'));
            
        $usr = User::find($id);
       
        $added_by =  $usr->added_by;
        
        $items = Menu::where('user_id', $added_by)->orderBy('created_at', 'desc')->get();

        // return response()->json($user,200);
        
        if($items->isNotEmpty()){

            foreach($items as $row){

                $data = $row;
                
                if($row->status == 1){
                        $data['status'] = 'Available';
                }
                elseif($row->status == 0){
                    $data['status'] = 'Unavailable';
                }
                
                // $data['price'] = $r->price;
                
                $menu_component = MenuComponent::where('menu_id', $row->id)->first();
                
                if(!empty($menu_component)){
                    $data['component'] = $menu_component->name;
                }
                else{
                    $data['component'] = 'Componet not Found';
                }
                

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','menu'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Menu found'];
            return response()->json($response,200);
        } 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
         $this->validate($request,[
            'name'=>'required',
            'price'=>'required',
            'id'=>'required',
            
        ]); 
        
        $usr = User::find($request->input('id'));
    
        if($usr){
            
            $added_by =  $usr->added_by;
            
            $data['name']=$request->name;
            $data['price']=$request->price;
            $data['status']='1';
            $data['user_id'] = $request->input('id');
            
            $data['added_by'] = $added_by;
            
            $menu= Menu::create($data);
            
            $items['name'] = $request->component;
            $items['order_no'] = 1;
            $items['user_id']= $request->input('id');
            $items['menu_id'] = $menu->id;
            
            MenuComponent::create($items);
            
            
            // if(!empty($menu)){
            // $activity =Activity::create(
            //     [ 
            //         'added_by'=> $menu->user_id,
            //         'module_id'=>$menu->id,
            //          'module'=>'Inventory',
            //         'activity'=>"Inventory " .  $menu->name. "  Created",
            //     ]
            //     );                      
            // }

        


            if($menu)
            {
                    if($menu->status == 1){
                        $menu['status'] = 'Available';
                    }
                    elseif($menu->status == 0){
                        $menu['status'] = 'Unavailable';
                    }
                
                $response=['success'=>true,'error'=>false, 'message' => 'Menu  Created successful', 'menu' => $menu];
                return response()->json($response, 200);
            }
        
            else
            {
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Menu Successfully'];
                return response()->json($response,200);
            }
            
      }
        else{
            $response=['success'=>false,'error'=>true,'message'=>'Failed to create Kitchen Menu Inventory, User not found'];
            return response()->json($response,200);
        }
        

        // $nameArr =$request->component ;
  
       
        
        //   if(!empty($nameArr)){
        //       for($i = 0; $i < count($nameArr); $i++){
        //           if(!empty($nameArr[$i])){
        //               $items = array(
        //                   'name' => $nameArr[$i],
        //                       'order_no' => $i,
        //                       'user_id'=>auth()->user()->added_by,
        //                   'menu_id' =>$menu->id);
       
        //               MenuComponent::create($items);  ;
       
       
        //           }
        //       }
        //   }    
       

        //  return redirect(route('menu-items.index'))->with(['success'=>'New Menu Created Successfully']);

    }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
         $menu=Menu::find($id);
        $items = MenuComponent::where('menu_id',$id)->get();
        return view('restaurant.menu-item.show',compact('items','menu'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data=Menu::find($id);
        $items = MenuComponent::where('menu_id',$id)->get(); 
        $type=""; 
        return view('restaurant.menu-item.index', compact('data','items','id','type'));

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
        
        $menu=Menu::find($id);

        if($request->type == ''){

        $data['name']=$request->name;
        $data['price']=$request->price;
        $menu->update($data);

        $nameArr =$request->item_name ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_id ;
       
       
         if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                  MenuComponent::where('id',$remArr[$i])->delete();        
                   }
               }
           }

           if(!empty($nameArr)){
               for($i = 0; $i < count($nameArr); $i++){
                   if(!empty($nameArr[$i])){
                       $items = array(
                        'name' => $nameArr[$i],
                        'order_no' => $i,
                        'user_id'=>auth()->user()->added_by,
                         'menu_id' =>$id);
                        
                           if(!empty($expArr[$i])){
                            MenuComponent::where('id',$expArr[$i])->update($items);  
      
      }
                          else{
                         MenuComponent::create($items);  
      
      }

                          
       
       
                   }
               }
           }    
       

      return redirect(route('menu-items.index'))->with(['success'=>'Menu Updated Successfully']);

        }


        else{


            $data['name']=$request->name;
            $data['price']=$request->price;
            $data['status']='1';
            $menu->update($data);
    
            $nameArr =$request->item_name ;
            $remArr = $request->removed_id ;
            $expArr = $request->saved_id ;
           
           
             if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                      MenuComponent::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
               if(!empty($nameArr)){
                   for($i = 0; $i < count($nameArr); $i++){
                       if(!empty($nameArr[$i])){
                           $items = array(
                            'name' => $nameArr[$i],
                            'order_no' => $i,
                            'user_id'=>auth()->user()->added_by,
                             'menu_id' =>$id);
                            
                               if(!empty($expArr[$i])){
                                MenuComponent::where('id',$expArr[$i])->update($items);  
          
          }
                              else{
                             MenuComponent::create($items);  
          
          }
    
                              
           
           
                       }
                   }
               }    
           
    
            return redirect(route('menu-items.index'))->with(['success'=>'Status Changed Successfully']);


        }
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MenuComponent::where('menu_id', $id)->delete();
        $menu = Menu::find($id);
        $menu->delete();

       return redirect(route('menu-items.index'))->with(['success'=>'Menu Deleted Successfully']);

    }

    public function change_status($id)
    {
        //
        
        $menu = Menu::find($id);
        if($menu->status == '1'){
        $item['status'] = 0;
        $menu->update($item);

          return redirect(route('menu-items.index'))->with(['success'=>'Status Changed Successfully']);
        }

        elseif($menu->status == '0'){
            $data=Menu::find($id);
            $items = MenuComponent::where('menu_id',$id)->get();
            $type="status"; 
             return view('restaurant.menu-item.index', compact('data','items','id','type'));
        }
    }
 
}
