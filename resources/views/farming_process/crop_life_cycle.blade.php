@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('farming.crop_cycle')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                 
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'preparation' || $type == 'edit-preparation') active  @endif" onclick="{ $type = 'preparation'}" id="#tab1" data-toggle="tab"
                                            href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">{{__('farming.land')}}</a>
                                    </li>
                              <li class="nav-item">
                                        <a class="nav-link @if($type == 'program' || $type == 'edit-program') active  @endif" onclick="{ $type = 'program'}" id="#program" data-toggle="tab"
                                            href="#program" role="tab" aria-controls="home"
                                            aria-selected="true">Farm Program</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'sowing' || $type == 'edit-sowing') active  @endif" onclick="{ $type = 'sowing'}" id="#sowing" data-toggle="tab"
                                            href="#sowing" role="tab" aria-controls="profile"
                                            aria-selected="false">{{__('farming.sowing')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'fertilizer') active  @endif" onclick="{ $type = 'fertilizer'}" id="#fertilizer" data-toggle="tab"
                                            href="#fertilizer" role="tab" aria-controls="profile"
                                            aria-selected="false">{{__('farming.fertilizer')}}</a>
                                    </li>
<!---
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'irrigation') active  @endif" onclick="{ $type = 'irrigation'}" id="#irrigation" data-toggle="tab"
                                            href="#irrigation" role="tab" aria-controls="profile"
                                            aria-selected="false">Irrigation</a>
                                    </li>
-->

                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'weeding') active  @endif" onclick="{ $type = 'weeding'}" id="#weeding" data-toggle="tab"
                                            href="#weeding"  role="tab" aria-controls="profile"
                                            aria-selected="false">Weeding</a>
                                    </li>
                                    
                                    
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'pestiside') active  @endif" onclick="{ $type = 'pestiside'}" id="#pestiside" data-toggle="tab"
                                            href="#pestiside" role="tab" aria-controls="profile"
                                            aria-selected="false">Pestiside</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'pre_harvest') active  @endif" onclick="{ $type = 'pre_harvest'}" id="#pre_harvest" data-toggle="tab"
                                            href="#pre_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Pre-Harvest</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'post_harvest') active  @endif" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Post-Harvest</a>
                                    </li>


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                 
                                 @include('farming_process.life_cycle_tabs.land_preparation')
                                    @include('farming_process.life_cycle_tabs.program')
                                 @include('farming_process.life_cycle_tabs.sowing')
                                 @include('farming_process.life_cycle_tabs.pestiside')

                                 @include('farming_process.life_cycle_tabs.pre-harvest')
                                 @include('farming_process.life_cycle_tabs.post-harvest')
                                   @include('farming_process.life_cycle_tabs.weeding')
                                 @include('farming_process.life_cycle_tabs.fertilizer')

                                 @include('farming_process.life_cycle_tabs.irrigation')

                               
                               
 

                                </div>
         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
 
</section>
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>
</div>
</div>

<div class="modal inmodal show" id="newFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>
</div>
</div>

@endsection

@section('scripts')
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>

<script>
    $(document).ready(function(){
      
      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });

 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("findPacelPrice")}}',
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
        html += '<td><input type="text" name="item_name[]" class="form-control item_quantity" data-category_id="'+count+'"placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><select name="status[]" class="form-control item_name" required  data-sub_category_id="'+count+'"><option value="">Select Item</option><option value="Available">Available</option><option value="Unavailable">Available</option></select></td>';       
       html += '<td><input type="text" name="cost[]" class="form-control item_price'+count+'" placeholder ="price"  value=""/></td>';
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
     url: '{{url("monitorModal")}}',
    data: {
        'id': id,
        'type':type,
         'seasson_id':{{$seasson_id}},
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

