@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>System Role</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">System Role
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New System Role</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                      <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 38.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 151.219px;">Name</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Daily Price</th>
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Monthly Price</th>
                                              
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Yearly Price</th> 
                                           

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 108.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($roles))
                                            @foreach ($roles as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->slug}}</td>
                                                 <td> {{number_format($row->day,2)}}</td>
                                                  <td> {{number_format($row->month,2)}}</td>
                                              <td> {{number_format($row->year,2)}}</td>
                                                                  


                                                <td>
                                                 <div class="form-inline">
                                                 
                                                
                                              <a class="list-icons-item text-primary"
                                                        href="{{ route("system_role.edit", $row->id)}}"><i
                                                            class="icon-pencil7"></i>
                                                    </a>
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
                                    @if(!empty($id))
                                            <h5>Edit System Role</h5>
                                            @else
                                            <h5>Add New System Role</h5>
                                            @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('system_role.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'system_role.store']) }}
                                                    @method('POST')
                                                    @endif

                                            <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Name</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="slug"
                                                        value="{{ isset($data) ? $data->slug : ''}}"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                           

                                            <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Yearly Price</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="year" id="year"
                                                        value="{{ isset($data) ? number_format($data->year) : '0'}}"
                                                        class="form-control year" required>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Monthly Price</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="month" id="month"
                                                        value="{{ isset($data) ? number_format($data->month) : '0'}}"
                                                        class="form-control month" readonly required>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Daily Price</label>

                                                <div class="col-lg-10">
                                                    <input type="text" name="day" id="day"
                                                        value="{{ isset($data) ? number_format($data->day) : '0'}}"
                                                        class="form-control day" readonly required>
                                                </div>
                                            </div>
                                                    
                                        
                                         <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Modules</label>

                                            <div class="col-lg-10">
                                               <textarea class="form-control name" name="notes" id="editor" placeholder="Enter your text..." required>{{ isset($data) ? $data->notes: ''}}</textarea>
                                            </div>
                                        </div>
                                    <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Message</label>

                                            <div class="col-lg-10">
                                               <textarea class="form-control" name="message" id="message" placeholder="Enter your message..." required>{{ isset($data) ? $data->message: ''}}</textarea>
                                            </div>
                                        </div>
                                        
                                           <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Link</label>

                                            <div class="col-lg-10">
                                               <textarea class="form-control" name="link" id="link" placeholder="Enter your link..." >{{ isset($data) ? $data->link: ''}}</textarea>
                                            </div>
                                        </div>
                                              
                                               <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                               
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right save"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right save"
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


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
    
    
      <script type="text/javascript">
$(document).ready(function() {
$('.year').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});


});
</script>


<script>
    $(document).ready(function() {
    
       $(document).on('change', '.year', function() {
            var id = $(this).val();
            
             var value = id.replace(/[^0-9\.]/g, ""); // remove commas from existing input
             console.log(value);
             
             var s=0.2* value;
             var z=parseInt(s);
             
             var x= parseInt(value);
             
              var y=0.1* value;
              var r=parseInt(y);
              
              var a=(z+ x)/365;
              var aa= Math.round(a/100)*100;
              
              
              var b=(r + x)/12;
              var bb= Math.round(b/100)*100;
               
                
               var d=addCommas(aa);
                 var m=addCommas(bb);

              $('#day').val(d);
              $('#month').val(m);

    
        });
        
        
        
         $(document).on('click', '.save', function(event) {
         var x=$(".year").val();
          var value = x.replace(/[^0-9\.]/g, ""); // remove commas from existing input
         $('.errors').empty();
        
         if(value == '0'){
           event.preventDefault(); 
          $('.errors').append('Prices cannot be zero.');
             
         }
         
         else{
            
          
         }
        
    });
    
    
    
    });
    </script>
    
      <script>
    
    function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

  </script>
  

<


@endsection