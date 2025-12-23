@extends('layouts.master')

@push('plugin-styles')

<style>

 .sales-sm .today-summary h5, .sales-sm .week-summary h5, .sales-sm .month-summary h5 {
    margin-left: 10px;
}

.sales-sm .row .col-5, .sales-sm .row .col-3, .sales-sm .row .col-4 {
    background: #01b2c6;
    padding: 0px;
}
 
    </style>

@endpush

@section('content')

 @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp

    <section class="section">
   
         <div class="card shadow-sm mx-auto" style="border-radius: 10px; border: none; max-width: 100%;">
            <!-- Card Header -->
            <div class="card-header bg-gradient-primary text-white" 
                 style="font-size: 1.2rem; font-weight: bold; padding: 10px 15px; background: linear-gradient(45deg, #007BFF, #0056b3);">Welcome Back
            </div>
            <!-- Card Body -->
            <div class="card-body" style="padding: 15px; background-color: #f9f9f9;">
                <div class="d-flex align-items-center">
                    <img src="https://img.icons8.com/laces/64/007BFF/home.png" width="40" height="40" style="margin-right: 10px;"/>
                    <h1 class="h6 mb-0" style="font-weight: bold; color: #0056b3;">Dashboard</h1>
                </div>
            </div>
        </div>



        <div class="row">
        
         @can('view-deposit')
        <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-info text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-stack primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($deposit, 2) }} Tsh</h3>
                                    <span>Total Deposit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            
             @can('view-expenses')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-danger text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-map4 primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($expense, 2) }} Tsh</h3>
                                    <span>Total Expenses</span>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
                        
         @can('view-cargo-invoice')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-primary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-book primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($invoice, 2) }} Tsh</h3>
                                    <span>Cargo Invoice for the year <?php echo date('Y'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-warning text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-file-minus primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($invoice - $due, 2) }} Tsh</h3>
                                    <span>Cargo Payments for the year <?php echo date('Y'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            
             @can('view-courier-menu')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-success text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-file-empty primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($courier_invoice, 2) }} Tsh</h3>
                                    <span>Courier Invoice for the year <?php echo date('Y'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-pink text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-file-empty2 primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($courier_invoice - $courier_due, 2) }} Tsh</h3>
                                    <span>Courier Payments for the year <?php echo date('Y'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
       
          
        



       
        @can('view-cargo-mileage')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-yellow text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-copy primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($mileage, 2) }} Tsh</h3>
                                    <span>Total Mileage</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
            
             @can('view-cargo-permit')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-secondary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-file-stats2 primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($permit, 2) }} Tsh</h3>
                                    <span>Total Border Permit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            
            
          
             
              @can('view-truck')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-warning text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-truck primary font-large-2 float-left fa-10x"
                                        style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($truck) }}</h3>
                                    <span>No of Trucks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
          
             @can('view-fuel')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-success text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-battery-6 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($fuel, 2) }} Litres</h3>
                                     <span>Fuel Used</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

            @can('view-tyre_list')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-pink text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-target primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($tire) }}</h3>
                                     <span>No of Tires</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan


           @can('view-courier_client')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-yellow text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-users4 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($courier_client) }}</h3>
                                     <span>No of Clients</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan


              @can('view-courier_activity')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-secondary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-car2 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($cou_trips) }} </h3>
                                     <span>No of Courier Trips</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
          
             @can('view-cargo-menu')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-info text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-bike primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($trips) }} </h3>
                                     <span>No of Cargo Trips</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
           
           @can('view-driver')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-danger text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-bus primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($driver) }}</h3>
                                     <span>No of Drivers </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
           
           @can('view-purchase')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-primary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-coins primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($pos_item) }} </h3>
                                     <span>Stock </span>
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

           
              @can('view-supplier')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-warning text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-user-plus primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($pos_supplier) }}  </h3>
                                     <span>Suppliers </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           @endcan
             
              @can('view-client')
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-success text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-users2 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($pos_client) }} </h3>
                                     <span>Clients </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              @endcan
          
              @can('view-purchase')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-pink text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-calendar primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($cogs, 2) }} </h3>
                                     <span>Cost of Sales </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

             @can('view-students')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-yellow text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-users primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($students) }}</h3>
                                     <span>Total Students </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

             @can('view-school-invoice')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-secondary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-pie-chart primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($sch_inv, 2) }}</h3>
                                     <span>Total School Invoice </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
             
             
              @can('view-school-invoice')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-warning text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-stack-minus primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($sch_dis, 2) }}</h3>
                                     <span>Total School Discount</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
            
            
             @can('view-school-collection')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-info text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-cash4 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($sch_pay, 2) }}</h3>
                                     <span>Total School Payments </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
             
            @can('view-hotel')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-yellow text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-city primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($property) }}</h3>
                                     <span>Property </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
             
             
             
             
              @can('view-hotel')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-success text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-bed2 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($rooms) }}</h3>
                                     <span>Rooms</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
             
             
              @can('view-booking')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-primary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-calendar3 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($booking) }}</h3>
                                     <span>Bookings</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

         @can('view-project-menu')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-danger text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-newspaper primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($projects) }}</h3>
                                     <span>Projects</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

           @can('view-tasks-menu')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-primary text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-stats-decline2 primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($tasks) }}</h3>
                                     <span>Tasks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan

          @can('view-milestone-menu')
             <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-warning text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-traffic-cone primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($milestone) }}</h3>
                                     <span>Milestone</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             @endcan
             
             
               @if (auth()->user()->email == 'info@ujuzinet.com')
              
          <div class="col-xl-3 col-sm-6 col-12">
                <div class="card bg-success text-white">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-traffic-cone primary font-large-2 float-left fa-10x" style="font-size: 40px;"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>{{ number_format($total_azam,2) }}</h3>
                                     <span>AZAM PAY PAYMENTS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
          
            
            
             @endif


          
        </div>

        <!-- /quick stats boxes -->




        <div class="row">
            @can('view-project-menu')
                <div class="col-xl-12">
                    <div class="card ">
                        <div class="card-header">
                            <h4 align="center">Recent Projects</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datatable-basic table-striped">
                                    <thead>
                                        <tr>
                                            <td><strong>Project</strong></td>

                                            <td><strong>Start Date</strong></td>
                                            <td><strong>Status</strong></td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (!empty($recent_pro))
                                            @foreach ($recent_pro as $row)
                                                <tr class="gradeA even" role="row">
                                                    <td><a href="{{ route('project.show', $row->id) }}">
                                                            {{ $row->project_name }} - {{ $row->project_no }}</a></td>

                                                    <td>{{ Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }} </td>
                                                    <td>
                                                        @if ($row->status == 'Cancelled')
                                                            <div class="badge badge-danger badge-shadow">{{ $row->status }}
                                                            </div>
                                                        @elseif($row->status == 'In Progress')
                                                            <div class="badge badge-info badge-shadow">{{ $row->status }}
                                                            </div>
                                                        @elseif($row->status == 'Completed')
                                                            <span
                                                                class="badge badge-success badge-shadow">{{ $row->status }}</span>
                                                        @else
                                                            <div class="badge badge-warning badge-shadow">{{ $row->status }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>


                            </div>
                        </div>

                    </div>
                </div>
            @endcan

        </div>

        <!-- /quick stats boxes -->

         <div class="row">
             @can('view-cargo-menu')
                <div class="col-xl-6">
                    <!-- Traffic sources -->
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                <div class="chart has-fixed-height" id="tracking"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /traffic sources -->
                </div>
            @endcan


            @can('view-courier-menu')
                <div class="col-xl-6">
                    <!-- Traffic sources -->
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                <div class="chart has-fixed-height" id="courier"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /traffic sources -->
                </div>
            @endcan
         </div>
         


        <!-- Main charts -->
        <div class="row">
           

       @can('view-pos-menu')
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">POS SUMMARY</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Today Summary -->
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Today</h5>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>Stock</strong>
                                                    <h4>{{ number_format($day_item) }}</h4>
                                                </div>
                                                <div>
                                                    <strong>Purchases</strong>
                                                    <h4>{{ number_format($day_pur,2) }}</h4>
                                                </div>
                                                <div>
                                                    <strong>Sales</strong>
                                                    <h4 class="todayE">{{ number_format($day_inv,2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <!-- This Week Summary -->
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">This Week</h5>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>Stock</strong>
                                                    <h4>{{ number_format($week_item) }}</h4>
                                                </div>
                                                <div>
                                                    <strong>Purchases</strong>
                                                    <h4>{{ number_format($week_pur,2) }}</h4>
                                                </div>
                                                <div>
                                                    <strong>Sales</strong>
                                                    <h4 class="weekE">{{ number_format($week_inv,2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <!-- This Month Summary -->
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">This Month</h5>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>Stock</strong>
                                                    <h4>{{ number_format($month_item) }}</h4>
                                                </div>
                                                <div>
                                                    <strong>Purchases</strong>
                                                    <h4>{{ number_format($month_pur,2) }}</h4>
                                                </div>
                                                <div>
                                                    <strong>Sales</strong>
                                                    <h4 class="monthE">{{ number_format($month_inv,2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                </div>
            @endcan


          @can('view-pos-menu')
                <div class="col-xl-12">
                    <!-- Traffic sources -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="font-15">Purchases vs Sales for the year <?php echo date('Y'); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="monthly_pos_data" class="chart" style="height: 320px;">
                                </div>
                            </div>
                        </div>
                        <!-- /traffic sources -->
                    </div>
                @endcan


                @can('view-payroll_summary')
                    <div class="col-xl-12">
                        <!-- Traffic sources -->
                        <div class="card">
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="payroll"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /traffic sources -->
                    </div>
                @endcan

            </div>











    </section>
@endsection

@section('scripts')
    
    
   
   <script src="{{ asset('assets/amcharts/amcharts.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/serial.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/pie.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/themes/light.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/plugins/export/export.min.js') }}"
            type="text/javascript"></script>

    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "ordering": false,
            "columnDefs": [{
                "targets": [1]
            }],
            dom: '<"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>


    <script>
        AmCharts.makeChart("monthly_pos_data", {
            "type": "serial",
            "theme": "light",
            "autoMargins": true,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "fontFamily": 'Open Sans',
            "color": '#888',

            "dataProvider": {!! $monthly_pos_data !!},
            "valueAxes": [{
                "axisAlpha": 0,

            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b> [[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "bulletSize": 8,
                "lineColor": "#4e96cdc7",
                "lineThickness": 5,
                "negativeLineColor": "#0dd102",
                "title": "Purchase",
                "type": "smoothedLine",
                "valueField": "purchase"
            }, {
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b> [[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "bulletSize": 8,
                "lineColor": "#3d9e78",
                "lineThickness": 5,
                "negativeLineColor": "#d1cf0d",
                "title": "Sales",
                "type": "smoothedLine",
                "valueField": "sales"
            }],
            "categoryField": "month",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0,
                "labelRotation": 30,

            },
            "export": {
                "enabled": true,
                "libs": {
                    "path": "{{ asset('assets/amcharts/plugins/export/libs') }}/"
                }
            },
            "legend": {
                "position": "bottom",
                "marginRight": 100,
                "autoMargins": false
            },


        });
    </script>

    <script type="text/javascript">
        var bars_basic_element = document.getElementById('tracking');
        if (bars_basic_element) {
            var bars_basic = echarts.init(bars_basic_element);
            bars_basic.setOption({

                // Setup grid
                grid: {
                    left: 0,
                    right: 0,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Order In Queue', 'Collected', 'Loaded', 'OffLoaded', 'Delivered'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },
                title: {
                    text: 'Cargo Tracking',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(0,0,0,0.025)'
                        }
                    }
                },

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.01],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: ['Order In Queue', 'Collected', 'Loaded', 'OffLoaded', 'Delivered'],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                        }
                    }
                }],


                series: [{
                    name: 'Cargo Tracking',
                    type: 'bar',
                    itemStyle: {
                        normal: {
                            color: '#5470c6'
                        }
                    },
                    data: [{
                            value: {{ $collection }},
                            name: 'Order In Queue'
                        },
                        {
                            value: {{ $loading }},
                            name: 'Collected'
                        },
                        {
                            value: {{ $off }},
                            name: 'Loaded'
                        },
                        {
                            value: {{ $del }},
                            name: 'OffLoaded'
                        },
                        {
                            value: {{ $dest }},
                            name: 'Delivered'
                        },
                    ]
                }]


            });



        }
    </script>

    <script type="text/javascript">
        var bars_basic_element = document.getElementById('courier');
        if (bars_basic_element) {
            var bars_basic = echarts.init(bars_basic_element);
            bars_basic.setOption({

                // Setup grid
                grid: {
                    left: 0,
                    right: 0,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Order in Queue', 'Picked', 'Freighted', 'Commissioned', 'Delivered'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },
                title: {
                    text: 'Courier Tracking',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(0,0,0,0.025)'
                        }
                    }
                },

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.01],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: ['Order in Queue', 'Picked', 'Freighted', 'Commissioned', 'Delivered'],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                        }
                    }
                }],


                series: [{
                    name: 'Courier Tracking',
                    type: 'bar',
                    itemStyle: {
                        normal: {
                            color: '#5470c6'
                        }
                    },
                    data: [{
                            value: {{ $cou_collection }},
                            name: 'Order in Queue'
                        },
                        {
                            value: {{ $cou_loading }},
                            name: 'Picked'
                        },
                        {
                            value: {{ $cou_off }},
                            name: 'Freighted'
                        },
                        {
                            value: {{ $cou_del }},
                            name: 'Commissioned'
                        },
                        {
                            value: {{ $cou_dest }},
                            name: 'Delivered'
                        },
                    ]
                }]


            });



        }
    </script>


    <script>
        // === include 'setup' then 'config' above ===
        const labels = <?php echo json_encode($month); ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Total Amount',
                data: <?php echo json_encode($amount); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        display: false,
                    },

                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Payroll Payments for the year <?php echo date('Y'); ?>',
                        font: {
                            size: 20
                        }
                    }
                }
            },
        };
    </script>

    <script>
        const myChart = new Chart(
            document.getElementById('payroll'),
            config
        );
    </script>
@endsection
