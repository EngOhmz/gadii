@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bill Of Material</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Bill Of Material List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Bill Of Material</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                   <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 146.484px;">Ref No</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Product</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Description</th>

                                              

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($billofmaterial))
                                            @foreach ($billofmaterial as $row)
                                            <tr class="gradeA even" role="row">

                                               <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('bill_of_material.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td> 
                                                
                                                <td>
                                                     {{$row->item->name}}
                                                </td>
                                                
                                                <td>
                                                    {{$row->description}}
                                                </td>
                                             

                                              
                                               
                                                <td>
                                                   <div class="form-inline">
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('bill_of_material.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp

                                                    {!! Form::open(['route' => ['bill_of_material.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    
                                                    </div>

                                                   

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
                                        <h5>Create Bill Of Material</h5>
                                        @else
                                        <h5>Edit Bill Of Material </h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('bill_of_material.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'bill_of_material.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="{{$type}}" />

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label">Enter Description Of Bill of Material</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="description"
                                                                    class="form-control"
                                                                    placeholder="Description....." required
                                                                    value="{{ isset($data) ? $data->description : ''}}" />
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-4 col-form-label">Products For Manufacture</label>
                                                      <div class="col-lg-8">
                                                   <select class="form-control m-b" name="product" required
                                                                id="product">
                                                                <option value="">Select Product Name</option>
                                                                @if(!empty($products))
                                                                @foreach($products as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->product == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif
                                                                
                                                                @if(!empty($bottles))
                                                                @foreach($bottles as $row2)

                                                                <option @if(isset($data))
                                                                    {{  $data->product == $row2->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row2->id}}">{{$row2->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select> 
                                                    </div>
                                                                
                                                </div>
                                                
                                                
                                                 <div class="form-group row">
                                                 <label class="col-lg-4 col-form-label">Excise Duty (Per Litre)</label>

                                                    <div class="col-lg-8">
                                                        <input type="number" name="duty_excess" step="any" required
                                                            value="{{ isset($data) ? $data->duty_excess : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                              <!--   <div class="form-group row">
                                                <label class="col-lg-4 col-form-label">Store Location For Manufacture</label>
                                                      <div class="col-lg-8">
                                                   <select class="form-control m-b" name="location_id" required
                                                                id="location_id">
                                                                <option value="">Select Store Location</option>
                                                                @if(!empty($locations))
                                                                @foreach($locations as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->location_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                                
                                                </div>  -->



                                                <br>
                                                <h4 align="center">Enter Materials To Be used</h4>
                                                <hr>

                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add Material</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Name</th>
                                                            <th>Quantity</th>
                                                            <th>Unit</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    <tfoot>
                                                        @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control m-b item_name" required
                                                                    data-sub_category_id={{$i->order_no}}>
                                                                    <option value="">Select Item</option>
                                                                    @foreach($name as $n) 
                                                                     <option @if(isset($i)) {{  $i->items_id == $n->id  ? 'selected' : ''}} @endif value="{{ $n->id}}" >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]" step="any"
                                                                    class="form-control item_quantity{{$i->id}}"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /></td>
                                                            
                                                            <td><input type="text" name="unit[]" 
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" />
                                                                </td>       
                                                      
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                                
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />    
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i
                                                                        class="fas fa-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                    </tfoot>
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('purchase_inventory.index')}}">
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

<!-- supplier Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addClientForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"  id="name"                                                                
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Phone</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="phone" id="phone"
                                                                class="form-control"  placeholder="+255713000000" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Email</label>
                                                        <div class="col-lg-10">
                                                            <input type="email" name="email" id="email"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Address</label>

                                                        <div class="col-lg-10">
                                                            <textarea name="address" id="address" class="form-control" required>  </textarea>
                                                                                                                    

</div>
                                                    </div>

  <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">TIN</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="TIN"  id="TIN"
                                                                value="{{ isset($data) ? $data->TIN : ''}}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                 
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveSupplier(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>

            </div>
        </div>
    </div>
</div>
</div>
</div>


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

<script>
$(document).ready(function() {

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("findInvPrice")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price' + sub_category_id).val(data[0]["price"]);
                $(".item_unit" + sub_category_id).val(data[0]["unit"]);
               
            }

        });

    });


});
</script>



<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=
            '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';
        html +=
            '<td><input type="number" step="any" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" required /></td>';
            
        html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count +
            '" placeholder ="unit" required /></td>';   
            
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('tbody').append(html);
      $('.m-b').select2({
                            });
        autoCalcSetup();
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


    $(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

});
</script>



<script type="text/javascript">
function model(id, type) {

    $.ajax({
        type: 'GET',
        url: '/courier/public/discountModal/',
        data: {
            'id': id,
            'type': type,
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

function saveSupplier(e) {
     
     var name = $('#name').val();
     var phone = $('#phone').val();
     var email = $('#email').val();
     var address = $('#address').val();
   var TIN= $('#TIN').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addSupp")}}',
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

                             $('#supplier_id').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}
</script>

@endsection