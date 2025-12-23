@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Courier Settings</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">


                            <div class="tab-pane active" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            
                                             
                                                {!! Form::open(array('route' => 'courier.save_settings',"enctype"=>"multipart/form-data")) !!}
                                                @method('POST')
                                               

                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Courier Prefix </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="prefix" 
                                                            value="{{ isset($sett) ? $sett->prefix : ''}}"
                                                            class="form-control prefix" id="prefix">
                                                    </div>
                                             <label class="col-lg-2 col-form-label">Courier Starting Number</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="start_no" 
                                                            value="{{ isset($sett) ? $sett->start_no : ''}}"
                                                            class="form-control start" id="start">
                                                    </div>

                                                </div>
                                                
                                                   

                                                    <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Courier Number Format</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="format" 
                                                            value="{{ isset($sett) ? $sett->format : ''}}"
                                                            class="form-control format" readonly>
                                                    </div>
                          
                                                </div>
                                                

                                     <input type="hidden" name="config_id"
                                                                class="form-control name_list"
                                                                value="{{ isset($sett) ? $sett->id : ''}}" />

                        <input type="hidden" name="id"
                                                                class="form-control name_list"
                                                                value="{{ isset($id) ? $id : ''}}" />
                                               
                                             
<br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                      
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                     
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
$(document).on("change", function () {

var prefix=$('#prefix').val();
console.log(prefix);
var start=$('#start').val();

var format=" "+prefix+"/00"+start+" "; 
$('.format').val(format);




});
</script>

@endsection