<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Restaurant\POS\Menu;
use App\Models\Restaurant\POS\MenuComponent;
use Illuminate\Http\Request;


class MenuItemController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           $index=Menu::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();;
           $type="";
            return view('restaurant.menu-item.index', compact('index','type'));

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
        $data['name']=$request->name;
        $data['price']=$request->price;
        $data['status']='1';
        $data['tax_rate']=$request->tax_rate;
        $data['user_id']=auth()->user()->id;
        $data['added_by']=auth()->user()->added_by;
        $menu= Menu::create($data);

        $nameArr =$request->component ;
  
       
        
           if(!empty($nameArr)){
               for($i = 0; $i < count($nameArr); $i++){
                   if(!empty($nameArr[$i])){
                       $items = array(
                           'name' => $nameArr[$i],
                              'order_no' => $i,
                              'user_id'=>auth()->user()->added_by,
                           'menu_id' =>$menu->id);
       
                       MenuComponent::create($items);  ;
       
       
                   }
               }
           }    
       

         return redirect(route('menu-items.index'))->with(['success'=>'New Menu Created Successfully']);

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
        $data['tax_rate']=$request->tax_rate;
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
             $data['tax_rate']=$request->tax_rate;
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
        //MenuComponent::where('menu_id', $id)->delete();
        $menu = Menu::find($id);
        $menu->update(['disabled'=> '1']);

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
