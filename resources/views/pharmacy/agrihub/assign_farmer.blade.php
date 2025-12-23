@extends('layouts.master')

@section('content')

  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <!-- alert -->
          @if(Session::get('messagev'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              {{Session::get('messagev')}}
            </div>
          </div>
          @endif
          @if(Session::get('messager')))
          <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              {{Session::get('messager')}}
            </div>
          </div>
           @endif

          <!-- end of alert -->
          <div class="card">
            <div class="card-header">
              <h4>{{__('farmer.assign_farmer')}}</h4>
            </div>
            <div class="card-body">

                  <ul class="nav nav-tabs" id="myTab4" role="tablist">
                     <li class="nav-item">
                      <a class="nav-link @if(empty($id)) active show @endif" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="true">Farmer List</a>
                    </li>
                  
                 
                  </ul>
                
 <div class="tab-content tab-bordered" id="myTab3Content">
                                
                    <divclass="tab-pane fade @if(empty($id)) active show @endif"  id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                     <div class="table-responsive">
                      @if(count($farm_all)>0)
                            <table class="table table-striped" id="table-2">
                             <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Assigned to</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                              <tbody>
                       
                              @foreach($farm_all as $row)

                                  <tr class="gradeA even" role="row">
                            <td>{{ $loop->iteration }}</td>
                                   <td>{{$row->firstname}} {{$row->lastname}}</td>
                                <td>{{$row->phone}}</td>
                                <td> {{$row->ward->name}}, {{$row->district->name}}, {{$row->region->name}}</td>
                                @if(!@empty($row->assign))
                             <td> {{$row->user->name}}</td>
                               @else
                            <td> </td>
                              @endif
                                <td>
                            <a class="nav-link" title="Assign" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" 
                            onclick="model({{ $row->id  }},'assign')">Assign</a>
                                </td>
                                 </tr>
                              @endforeach
                            
                              

                            </tbody>
         
                               @endif
                            
                          </table>
                      
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
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>
</div>
</div>

  

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectDistrictid").empty();
                $("#selectDistrictid").append('<option value="">Select district</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectDistrictid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });


});
</script>

<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("farmerModal")}}',
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

@endsection