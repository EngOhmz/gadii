@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Category</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Category
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Category</a>
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
                                                    style="width: 26.484px;"># </th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 176.484px;">Category Name </th>                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Category Description</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($category))
                                            @foreach ($category as $row)
                                            <tr class="gradeA even" role="row">
                                                <td>{{$loop->iteration}}</td>
                                                     <td>{{$row->name}}</td>
                                                
                                                <td>{{$row->description}}</td>
                                                       
                                                <td>
                                                    
                                                   <div class="form-inline">
                                                       
                                                        
<a class="list-icons-item text-primary" title="Edit"  href="{{ route("category.edit",$row->id)}}"><i class="icon-pencil7"></i></a>&nbsp
                                                       

                                                            {!! Form::open(['route' => ['category.destroy',$row->id], 'method' => 'delete']) !!}
                                                           {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
&nbsp
                                                       
                   
                            
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
                                        <h5>Create Category</h5>
                                        @else
                                        <h5>Edit Category</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('category.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'category.store']) }}
                                                @method('POST')
                                                @endif

                                                       <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Category Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" 
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                 
                                                  <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Category Description</label>
                                                    <div class="col-lg-8">
                                                    <textarea class="form-control" name="description">{{ isset($data) ? $data->description : ''}}</textarea>
                                                      
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
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
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection

@section('scripts')



<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [0]}
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
    $(document).ready(function(){
   

 $(document).on('change', '.type', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Yes') {
          $('.end').show(); 
        } 
   else  {
           $('.end').hide();
        } 
});


    });
</script>


<script>

$("#example-select-all2").click(function() {
  $(".checks2").prop("checked", $(this).prop("checked"));
});

$(".checks2").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all2").prop("checked", false);
  }
});


</script>



<script>

$("#example-select-all").click(function() {
  $(".checks").prop("checked", $(this).prop("checked"));
});

$(".checks").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});


</script>

<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("project/projectModal")}}',
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

    </script>


<script type="text/javascript">
   function saveCategory(e){

$.ajax({
    type: 'GET',
     url: '{{url("project/saveCategory")}}',
    data:  $('#addCategoryForm').serialize(),
                dataType: "json",

    success: function(data) {
        //alert(data);

        var id = data.id;
         var name = data.category_name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 
                             

                             $('#category_id').append(option);
                              $('#appFormModal').hide();
                               $('.modal-backdrop').remove();
    }
   
});

}

    </script>

@endsection