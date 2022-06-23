@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Production</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Cotton Production
                                    </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Production</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Lot No</th>

                                                 
                                                    
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">weight Note</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                               
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Client</th> 

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Net Weight</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Gross Weight</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($production))
                                            @foreach ($production as $row)
                                            <tr class="gradeA even" role="row">
                                               
                                                <td><a href="{{ route('production.show', $row->id)}}">{{$row->lot_no}}</a></li></td>
                                                <td>{{$row->weight_note}}</td>
                                                <td>{{$row->location}}</td>
                                                <td>From {{ App\Models\ChartOfAccount::find($row->client)->name }}</td>
                                                
                                                <td>{{$row->net_weight}}</td>
                                                <td>{{$row->gross_weight}}</td>
                                                


                                            
                                              
                                        <td>
 <a  class="btn btn-xs btn-outline-info text-uppercase px-2 rounded" title="Edit" href="{{ route('production.edit', $row->id)}}"><i class="fa fa-edit"></i></a>

 {!! Form::open(['route' => ['courier_quotation.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
{{ Form::close() }}

                 <div class="btn-group">
        <button class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Change<span class="caret"></span></button>
        <ul class="dropdown-menu animated zoomIn">
         <li class="nav-item"><a  class="nav-link" title="Edit" class="discount"  href="{{ route('production.show', $row->id)}}"  >View Details</a></li>
          
                          </ul></div>

                                                </td>
                                              
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Production</h5>
                                        @else
                                        <h5>Edit Production</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('production.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'production.store']) }}
                                                @method('POST')
                                                @endif



                                                  <div class="form-group row">
                                                           <label class="col-lg-2 col-form-label">Weight Note No</label>
                                                    <div class="col-lg-4">
                                                       <input type="text" name="weight_note"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->weight_note : ''}}"
                                                            class="form-control" required>
                                                    </div> 
                                                     <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                       <input type="date" name="date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->date : date('y/m/d')}}" {{Auth::user()->can('edit-date') ? '' : 'readonly'}}
                                                            class="form-control" required>
                                                    </div> 

                                                             
             
         </div>                                      

                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Location/Ginnery</label>
                                                    <div class="col-lg-4">
                                                       <input type="text" name="location"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->location : ''}}"
                                                            class="form-control" required>
                                                    </div> 
                                                   
                                                    <label class="col-lg-2 col-form-label">Lot No</label> 
                                                    <div class="col-lg-4">
                                                        <input type="text" name="lot_no"
                                                           
                                                            value="{{ isset($data) ? $data->lot_no : ''}}"  
                                                            class="form-control">
                                                    </div> 
                                                    
                                                </div>
                                              <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Client</label>
                                                    <div class="col-lg-4">
                                                    <select class="m-b" name="client" id="client" required>
                                                  <option value="">Select </option>
                                                    <?php  $client = App\Models\AccountCodes::where('account_group','LIKE','%Sundry Debtors%')->get(); ; ?>
                                                    @if(!empty($client))
                                                    @foreach($client as $row)
                                                    <option value="{{$row->id}}" {{ !empty($data->client) ? ($data->client == $row->id)? 'selected' : '' : ''}}>{{$row->account_name}}</option>
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                       
                                                    </div> 
                                                    @if(isset($data)) 
                                                    <label class="col-lg-2 col-form-label">Total Bale Weight</label> 
                                                    <div class="col-lg-4">
                                                        <input type="number" name="balance_weight" id="balance_weight" readonly
                                                           
                                                            value="{{ isset($data) ? $data->bale_weight : ''}}"  
                                                            class="form-control">
                                                    </div>
                                                    @else
                                                     
                                                    <label class="col-lg-2 col-form-label">Tale</label> 
                                                    <div class="col-lg-4">
                                                        <input type="text" name="tale" id="tale"
                                                           
                                                            value="{{ isset($data) ? $data->tale : ''}}"  
                                                            class="form-control">
                                                    </div> 
                                                    @endif
                                                </div>
                                                    <div class="form-group row">
                                                @if(isset($data)) 
                                                    <label class="col-lg-2 col-form-label">Tale</label> 
                                                    <div class="col-lg-4">
                                                        <input type="text" name="tale" id="tale"
                                                           
                                                            value="{{ isset($data) ? $data->tale : ''}}"  
                                                            class="form-control">
                                                    </div> 
                                                    @endif
                                                </div>
                                     <br>
                                     <br>
                                               <h5 align="center">SPECIFICATION FOR 100 BALES FULL PRESSED LINT AR/BR</h5>
                                            <hr>

                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
                        
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th colspan="6">.</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
<tfoot>
@if(!empty($id))
   @if(!empty($data->productionList))
   <?php $x=0; ?>
    <tr class="line_items">
    @foreach ($data->productionList as $i)
    <?php $x++; ?>
<td><label class="col-form-label">bale{{$x}}</label><input type="hidden"name="id{{$x}}" value="{{$x}}"><input type="text" name="bale[]" value="{{$i->bale}}" class="form-control item_unit{{$x}}" placeholder ="{{$x}}" required /></td>
  @if(fmod($x,5) == 0)
  <td><button type="button" name="remove" class="btn btn-danger btn-xs rem" value= "{{ isset($i) ? $i->id : ''}}"><i class="fas fa-trash"></i></button></td>
    </tr>
     <tr>
  @elseif($x == count($data->productionList))
     </tr>
    @endif

@endforeach
 @endif
 @endif






</tfoot>
          </table>


    
                                                <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('courier_quotation.index')}}">
                                                                 cancel
                                                            </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

 <!-- discount Modal -->
  <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>


 <!-- route Modal -->
  <div class="modal inmodal show" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <p><strong>Make sure you enter valid information</strong> .</p>

       <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">from</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="arrival_point"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">To</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="destination_point"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Distance</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="distance"
                                                                class="form-control">
                                                        </div>
                                                    </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


    </div>
</div>
    </div>
</div></div>
  </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
 new TomSelect("#client",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function(){
      
      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });

 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                     $('.item_price'+sub_category_id).val(data[0]["price"]);
                      $(".item_unit"+sub_category_id).val(data[0]["unit"]);
                    $(".item_saved"+sub_category_id).val(data[0]["id"]);
          }

        });

});


    });
</script>


    
    <script type="text/javascript">
        
          $(document).ready(function(){

      
      var count = 0;


            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
                $('table#cart').jAutoCalc({decimalPlaces: 2});
            }
            autoCalcSetup();

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html += '<td><label class="col-form-label">bale'+count+'</label><input type="hidden"name="id+count+" value="'+count+'"><input type="text" name="bale[]" class="form-control item_unit'+count+'" placeholder ="'+count+'" required /></td>';
           count++;
        html += '<td><label class="col-form-label">bale'+count+'</label><input type="hidden"name="id+count+" value="'+count+'"><input type="text" name="bale[]" class="form-control item_unit'+count+'" placeholder ="'+count+'"  /></td>';
           count++;
        html += '<td><label class="col-form-label">bale'+count+'</label><input type="hidden"name="id+count+" value="'+count+'"><input type="text" name="bale[]" class="form-control item_unit'+count+'" placeholder ="'+count+'"  /></td>';
           count++;
        html += '<td><label class="col-form-label">bale'+count+'</label><input type="hidden"name="id+count+" value="'+count+'"><input type="text" name="bale[]" class="form-control item_unit'+count+'" placeholder ="'+count+'"  /></td>';
           count++;
        html += '<td><label class="col-form-label">bale'+count+'</label><input type="hidden"name="id+count+" value="'+count+'"><input type="text" name="bale[]" class="form-control item_unit'+count+'" placeholder ="'+count+'"  /></td>';

          
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';
    

        $('tbody').append(html);
autoCalcSetup();
      });

  $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
autoCalcSetup();
      });
      

 $(document).on('click', '.rem', function(){  
      var btn_value = $(this).attr("value");   
               $(this).closest('tr').remove();  
            $('tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
         autoCalcSetup();
           });  

        });
        


    </script>



<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("courierModal")}}',
            data: {
                'id': id,
                'type':type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    
    function calculateDiscount() {

      $('#discount').on('input',function() {
    var price= parseInt($('#discount').val());
    var qty = parseFloat($('#old').val());
console.log(price);
    $('#total').val((qty -price ? qty - price : 0).toFixed(2));
});

    }


    function saveClient(e){
  
     
     var name = $('#name').val();
     var phone = $('#phone').val();
     var email = $('#email').val();
     var address = $('#address').val();
   var TIN= $('#TIN').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addCourierSupplier")}}',
             data: {
                 'name':name,
                 'phone':phone,
                 'email':email,
                 'address':address,
                  'TIN':TIN,
             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#supplier').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}


    function saveRoute(e){
     
     
     var to = $('#to').val();
     var distance = $('#distance').val();
     var from = $('#from').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addRoute")}}',
             data: {
                 'to':to,
                 'distance':distance,
                 'from':from,
             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var arrival_point = response.from;
                              var destination_point = response.to;

                             var option = "<option value='"+id+"'  selected>From "+arrival_point+" to "+destination_point+"</option>"; 

                             $('#route').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
          
        });
}
    </script>

@endsection