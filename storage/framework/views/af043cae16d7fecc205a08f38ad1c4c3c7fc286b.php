<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo e(url('home')); ?>">
                <?php
                  $settings= App\Models\System::first();
                  //$settings= App\Models\System::all()->where('added_by',auth()->user()->user_id);
?>
                <img alt="image" src="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($settings->picture); ?>" class="header-logo" />
                <span class="logo-name"></span>
            </a>
        </div>
        <ul class="sidebar-menu active show">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-dashboard')): ?>
            <li class="dropdown <?php echo e(request()->is('/dashboard') ? 'active' : ''); ?>">
                <a href="<?php echo e(url('home')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-farmer')): ?>
            <li class="dropdown <?php echo e(request()->is('farmer/') ? 'active' : ''); ?> ">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span><?php echo e(__('farmer.farmer')); ?></span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-farmer')): ?>
                    <li class="<?php echo e(request()->routeIs('farmer.*')? 'active': ''); ?> active"><a class="nav-link"
                            href="<?php echo e(url('farmer/')); ?>"><?php echo e(__('farmer.manage_farmer')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-group')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('manage-group')); ?>"><?php echo e(__('farmer.manage_group')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-farmer')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('assign_farmer/')); ?>"><?php echo e(__('farmer.assign_farmer')); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-farming')): ?>
            <li class="dropdown">

                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span><?php echo e(__('farming.farming')); ?></span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manage-farming')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('crop_type')); ?>">Crop Type</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manage-farming')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('seed_type')); ?>">Seed Type</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manage-farming')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('pesticide_type')); ?>">Pesticide Type</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-view-farmer-assets')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('register_assets')); ?>"><?php echo e(__('farming.farmer_assets')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-view-farming-cost')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('farming_cost')); ?>"><?php echo e(__('farming.farming_cost')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-view-cost-centre')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('cost_centre')); ?>"><?php echo e(__('farming.cost_centre')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-view-farming-process')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('farming_process')); ?>">GAP</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-view-crop-monitoring')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('crops_monitoring')); ?>"><?php echo e(__('farming.crop_monitoring')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manage-farming')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('lime_base')); ?>">Lime Base</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manage_seasson')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('seasson')); ?>"><?php echo e(__('farming.manage_seasson')); ?></a></li>
                    <?php endif; ?>
                </ul>

            </li>
            <?php endif; ?>

  

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-orders')): ?>
            <li class="dropdown">

                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span><?php echo e(__('ordering.orders')); ?></span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-order_list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('orders')); ?>"><?php echo e(__('ordering.order_list')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-quotation-list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('quotationList')); ?>"><?php echo e(__('ordering.quotationList')); ?></a></li>
                    <?php endif; ?>
                    <li><a class="nav-link" href="<?php echo e(url('crops_order')); ?>">Create Order</a></li>

                </ul>

            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-orders')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Cargo
                        Management</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('pacel_list')); ?>">Item List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-client-list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('client')); ?>">Client List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-quotation')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('pacel_quotation')); ?>">Quotation</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-invoice')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('pacel_invoice')); ?>">Invoice</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-mileage')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('mileage')); ?>">Mileage List</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-orders')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Cargo
                        Tracking</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-collection')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('collection')); ?>"> Cargo List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-loading')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('loading')); ?>"> Loading</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-offloading')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('offloading')); ?>"> Offloading</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-delivering')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('delivering')); ?>">Delivery</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-wb')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('wb')); ?>">Download WB</a></li>
                    <?php endif; ?>                   
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-activity')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('activity')); ?>">Track Logistic Activity</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-order_report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('order_report')); ?>">Uplift Report</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cargo-truck_mileage')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('truck_mileage')); ?>">Return Truck Fuel & Mileage</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-courier')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Courier
                        Management</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_list')); ?>">Item List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_client')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_client')); ?>">Client List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_quotation')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_quotation')); ?>">Quotation</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_invoice')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_invoice')); ?>">Invoice</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-courier')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Courier
                        Tracking</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_collection')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_collection')); ?>"> Courier Collection</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_loading')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_loading')); ?>"> Courier Loading</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_offloading')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_offloading')); ?>"> Courier Offloading</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_delivering')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_delivering')); ?>"> Courier Delivery</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_activity')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_activity')); ?>">Track Courier Activity</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-courier_activity')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('courier_activity')); ?>"> Courier Uplift Report</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-payroll')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Payroll</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-salary_template')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/salary_template')); ?>"> Salary Template</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manage_salary')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/manage_salary')); ?>"> Manage Salary</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-employee_salary_list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/employee_salary_list')); ?>"> Employee Salary List</a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-make_payment')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/make_payment')); ?>">Make Payment</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-generate_payslip')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/generate_payslip')); ?>">Generate Payslip</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-payroll_summary')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/payroll_summary')); ?>">Payroll Summary</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-advance_salary')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/advance_salary')); ?>">Advance Salary</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-employee_loan')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/employee_loan')); ?>">Employee Loan</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-overtime')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/overtime')); ?>">Overtime</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-nssf')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/nssf')); ?>">Social Security (NSSF) </a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-tax')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/tax')); ?>">Tax </a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-nhif')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/nhif')); ?>">Health Contribution</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-wcf')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('payroll/wcf')); ?>">WCF Contribution</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-warehouse')): ?>
            <li><a class="nav-link" href="<?php echo e(url('warehouse')); ?>"><i data-feather="command"></i>Warehouse</a></li>
            <?php endif; ?>
<!--
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-logistic')): ?>
            <li><a class="nav-link" href="<?php echo e(url('routes')); ?>"><i data-feather="command"></i>Routes</a></li>
            <?php endif; ?>
--!>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-shop')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span><?php echo e(__('shop.shop')); ?></span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-supplier')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('manage/supplier')); ?>"><?php echo e(__('shop.manage_supplier')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-product')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('items')); ?>"><?php echo e(__('shop.manage_product')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-purchase')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('purchase')); ?>"><?php echo e(__('shop.purchase')); ?></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-sales')): ?>
                    <li><a class="nav-link" href="<?php echo e(('sales')); ?>"><?php echo e(__('shop.sales')); ?></a></li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php endif; ?>

   

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-inventory')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Tire
                        Management</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-tyre_brand')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('tyre_brand')); ?>">Tire Brand</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-purchase_tyre')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('purchase_tyre')); ?>">Purchase Tire</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-tyre_list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('tyre_list')); ?>">Tire List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-assign_truck')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('assign_truck')); ?>">Assign Truck</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-tyre_return')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('tyre_return')); ?>">Good Return</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-tyre_reallocation')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('tyre_reallocation')); ?>">Good Reallocation</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-tyre_disposal')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('tyre_disposal')); ?>">Good Disposal</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-inventory')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Inventory</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-location')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('location')); ?>">Location</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-inventory')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('inventory')); ?>">Inventory Items</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-fieldstaff')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('fieldstaff')); ?>">Field Staff</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-purchase_inventory')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('purchase_inventory')); ?>">Purchase Inventory</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-inventory_list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('inventory_list')); ?>">Inventory List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-maintainance')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('maintainance')); ?>">Maintainance</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-service')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('service')); ?>">Service</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-service')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('service')); ?>">Good Issue</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_return')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_return')); ?>">Good Return</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_return')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_movement')); ?>">Good Movement</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_reallocation')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_reallocation')); ?>">Good Reallocation</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_disposal')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_disposal')); ?>">Good Disposal</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-farmer')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Manufacturing</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-location')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('manufacturing_location')); ?>">Location</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-inventory')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('manufacturing_inventory')); ?>">Inventory Items</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-fieldstaff')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('fieldstaff')); ?>">Field Staff</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-purchase_inventory')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('bill_of_material')); ?>">Bill Of Material</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-purchase_inventory')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('work_order')); ?>">Work Order</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-purchase_inventory')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('manufacturing_purchase_inventory')); ?>">Purchase Inventory</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-inventory_list')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('inventory_list')); ?>">Inventory List</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-maintainance')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('maintainance')); ?>">Maintainance</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-service')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('service')); ?>">Service</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-service')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('service')); ?>">Good Issue</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_return')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_return')); ?>">Good Return</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_return')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_movement')); ?>">Good Movement</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_reallocation')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_reallocation')); ?>">Good Reallocation</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-good_disposal')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('good_disposal')); ?>">Good Disposal</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            
<?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-cotton')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Cotton Collection</span></a>
                <ul class="dropdown-menu">
                 
                  
                 
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-top-up-operator')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('top_up_operator')); ?>">Top up Operators</a></li>
                    <?php endif; ?>                 
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-top-up-center')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('top_up_center')); ?>">Top up Collection Center</a></li>
                    <?php endif; ?>
                
               
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cotton-purchase')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('purchase_cotton')); ?>">Stock Control</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cotton-movement')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('cotton_movement')); ?>">Stock Movement</a></li>
                    <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reverse-top-up-center')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('reverse_top_up_center')); ?>"> Reversed  Collection Center</a></li>
                    <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reverse-top-up-operator')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('reverse_top_up_operator')); ?>"> Reversed Operator </a></li>
                    <?php endif; ?>
                    
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-district')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('district')); ?>"> Manage District </a></li>
                    <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-operator')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('operator')); ?>">Manage Operator</a></li>
                    <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-center')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('collection_center')); ?>">Manage Collection Center</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-items')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('cotton_list')); ?>">Stock List</a></li>
                    <?php endif; ?>
                          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-items')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('levy_list')); ?>">Manage Levy</a></li>
                    <?php endif; ?>
               
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reverse-top-up-operator')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('complete_operator')); ?>"> Complete Top Up Operator </a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reverse-top-up-center')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('complete_center')); ?>"> Complete Top Up Centers</a></li>
                    <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-connect')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('assign_center')); ?>">Assign Equipment to Center</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-connect')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('reverse_assign_center')); ?>">Reversed Center Equiment</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-cotton')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Cotton Production</span></a>
                <ul class="dropdown-menu">
                 
                  
                 
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-top-up-operator')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('costants')); ?>">Constants</a></li>
                    <?php endif; ?>                 
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-top-up-center')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('production')); ?>">Make Production</a></li>
                    <?php endif; ?>

                
                </ul>
            </li>
            <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-cotton')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Invoice</span></a>
                <ul class="dropdown-menu">
 
                       
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cotton-invoice')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('cotton_sales')); ?>">Cotton Sales</a></li>
                    <?php endif; ?>
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-seed-invoice')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('seed_list')); ?>">Seed List</a></li>
                    <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-seed-invoice')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('seed_sales')); ?>">Seed Sales</a></li>
                    <?php endif; ?>
                
                </ul>
            </li>
            <?php endif; ?>
            
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-logistic')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Truck &
                        Driver</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-truck')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('truck')); ?>">Truck Management</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-driver')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('driver')); ?>">Driver Management</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-fuel')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('fuel')); ?>">Fuel Control</a></li>
                    <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-connect')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('connect_trailer')); ?>">Connect & Disconnect Trailer</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-connect')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('assign_driver')); ?>">Assign Equipment to Truck</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-connect')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('reverse_assign_driver')); ?>">Reversed Truck Equipment</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-leave')): ?>
            <li><a class="nav-link" href="<?php echo e(url('leave')); ?>"><i data-feather="command"></i>Leave Management</a></li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-training')): ?>
            <li><a class="nav-link" href="<?php echo e(url('training')); ?>"><i data-feather="command"></i>Training</a></li>
            <?php endif; ?>

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-gl-setup')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>GL
                        SETUP</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-class_account')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('class_account')); ?>">Class Account </a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-group_account')): ?>
                    <li class=" "><a class="nav-link" href="<?php echo e(url('group_account')); ?>">Group Account</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-account_codes')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('account_codes')); ?>">Account Codes</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-chart_of_account')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('chart_of_account')); ?>">Chart of Accounts </a></li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-transaction')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Transactions</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-deposit')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('deposit')); ?>">Deposit</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-expenses')): ?>
                    <li class=" "><a class="nav-link" href="<?php echo e(url('expenses')); ?>">Payments</a></li>
                    <?php endif; ?>
                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-transfer')): ?>
                 <li class=""><a class="nav-link" href="<?php echo e(url('transfer2')); ?>">Transfer</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-expenses')): ?>
                    <li class=" "><a class="nav-link" href="<?php echo e(url('account')); ?>">Bank & Cash</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-bank_statement')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('accounting/bank_statement')); ?>">Bank Statement</a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-bank_reconciliation')): ?>
                    <li class=" "><a class="nav-link" href="<?php echo e(url('accounting/bank_reconciliation')); ?>">Bank
                            Reconciliation</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reconciliation_report')): ?>
                    <li class=" "><a class="nav-link" href="<?php echo e(url('accounting/reconciliation_report')); ?>">Bank
                            Reconciliation Report</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>


           
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-accounting')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Accounting</span></a>
                <ul class="dropdown-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-manual_entry')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('accounting/manual_entry')); ?>">Journal Entry</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-journal')): ?>
                    <li class=" "><a class="nav-link" href="<?php echo e(url('accounting/journal')); ?>">Journal Entry Report</a>

                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-ledger')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('accounting/ledger')); ?>">Ledger</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-trial_balance')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('financial_report/trial_balance')); ?>">Trial Balance </a>
                    </li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-trial_balance')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('financial_report/trial_balance_summary')); ?>">Trial Balance Summary </a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-income_statement')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('financial_report/income_statement')); ?>">Income
                            Statement</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-income_statement')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('financial_report/income_statement_summary')); ?>">Income
                            Statement Summary</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-balance_sheet')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('financial_report/balance_sheet')); ?>">Balance Sheet </a>
                    </li>
                    <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-balance_sheet')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('financial_report/balance_sheet_summary')); ?>">Balance Sheet Summary </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-cotton')): ?>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span>Reports</span></a>
                <ul class="dropdown-menu">                           
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-stock-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('stock_report')); ?>"> Stock Report</a></li>
                    <?php endif; ?>
                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-invoice-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('invoice_report')); ?>"> Invoice Report</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-center-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('center_report')); ?>"> Collection Center Report</a></li>
                    <li><a class="nav-link" href="<?php echo e(url('cotton_movement_report')); ?>"> Cotton Movement Report</a></li>
                    <?php endif; ?>
                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-levy-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('levy_report')); ?>"> Levy Report</a></li>
                    <?php endif; ?>
                       <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-levy-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('debtors_report')); ?>"> Debtors Report</a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-center-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('general_report')); ?>"> Report By District</a></li>
                    <?php endif; ?>
                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-center-report')): ?>
                    <li><a class="nav-link" href="<?php echo e(url('general_report2')); ?>"> General Report </a></li>
                    <?php endif; ?>
     </ul>
            </li>
 <?php endif; ?>
   
  <li><a class="nav-link" href="<?php echo e(url('chatify')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Chatting</span>  </a></li>
 

         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-access-control')): ?>
            <li class="dropdown<?php echo e(request()->is('setting/*') ? 'active' : ''); ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="command"></i><span><?php echo e(__('permission.access_control')); ?></span></a>
                <ul class="dropdown-menu">

                    <li class="<?php echo e(request()->is('setting/roleGroup') ? 'active' : ''); ?>"><a class="nav-link"
                            href="<?php echo e(url('roles')); ?>">
                            <?php echo e(__('permission.roles')); ?></a>
                    </li>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-permission')): ?>
                    <li class="<?php echo e(request()->is('setting/roleGroup') ? 'active' :''); ?> "><a class="nav-link"
                            href="<?php echo e(url('permissions')); ?>"><?php echo e(__('permission.permissions')); ?></a>

                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('system')); ?>"><?php echo e(__('permission.system_setings')); ?></a>

                    </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('departments')); ?>">Departments
                        </a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                    <li class=""><a class="nav-link" href="<?php echo e(url('designations')); ?>">Designations
                        </a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                    <li class="<?php echo e(request()->is('users') ? 'active' : ''); ?>"><a class="nav-link"
                            href="<?php echo e(url('users')); ?>"><?php echo e(__('permission.user')); ?>

                            Management</a></li>
                    <?php endif; ?>


                </ul>
            </li>
<?php endif; ?>


    </aside>
</div><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/layouts/aside.blade.php ENDPATH**/ ?>