<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
       
       
     
         
        $data = [
            #1. manage-dashboard permissions
            ['slug' => 'view-dashboard','sys_module_id'=>1],
            ['slug' => 'edit-dashboard','sys_module_id'=>1],
            ['slug' => 'delete-dashboard','sys_module_id'=>1],
            ['slug' => 'add-dashboard','sys_module_id'=>1],
           

            // end manage-User permissions

            #2.start manage-farmer permissions
            ['slug' => 'view-farmer','sys_module_id'=>2],
            ['slug' => 'edit-farmer','sys_module_id'=>2],
            ['slug' => 'delete-farmer','sys_module_id'=>2],
            ['slug' => 'add-farmer','sys_module_id'=>2],
            ['slug' => 'confirm-farmer','sys_module_id'=>2],

            ['slug' => 'view-group','sys_module_id'=>2],
            ['slug' => 'edit-group','sys_module_id'=>2],
            ['slug' => 'delete-group','sys_module_id'=>2],
            ['slug' => 'add-group','sys_module_id'=>2],
            ['slug' => 'confirm-group','sys_module_id'=>2],
            // end manage-farmer permissions

            #3.start manage-farming permissions
            ['slug' => 'view-farmer-assets','sys_module_id'=>3],
            ['slug' => 'edit-farmer-assets','sys_module_id'=>3],
            ['slug' => 'delete-farmer-assets','sys_module_id'=>3],
            ['slug' => 'add-farmer-assets','sys_module_id'=>3],

            ['slug' => 'view-farming-cost','sys_module_id'=>3],
            ['slug' => 'edit-farming-cost','sys_module_id'=>3],
            ['slug' => 'delete-farming-cost','sys_module_id'=>3],
            ['slug' => 'add-farming-cost','sys_module_id'=>3],

            ['slug' => 'view-cost-centre','sys_module_id'=>3],
            ['slug' => 'edit-cost-centre','sys_module_id'=>3],
            ['slug' => 'delete-cost-centre','sys_module_id'=>3],
            ['slug' => 'add-cost-centre','sys_module_id'=>3],

            ['slug' => 'view-farming-process','sys_module_id'=>3],
            ['slug' => 'edit-farming-process','sys_module_id'=>3],
            ['slug' => 'delete-farming-process','sys_module_id'=>3],
            ['slug' => 'add-farming-process','sys_module_id'=>3],

            ['slug' => 'view-crop-monitoring','sys_module_id'=>3],
            ['slug' => 'edit-crop-monitoring','sys_module_id'=>3],
            ['slug' => 'delete-crop-monitoring','sys_module_id'=>3],
            ['slug' => 'add-crop-monitoring','sys_module_id'=>3],

            ['slug' => 'view-manage_seasson','sys_module_id'=>3],
            ['slug' => 'edit-manage_seasson','sys_module_id'=>3],
            ['slug' => 'delete-manage_seasson','sys_module_id'=>3],
            ['slug' => 'add-manage_seasson','sys_module_id'=>3],
            
            // end manage-request permissions

          #2.start manage-orders permissions
          ['slug' => 'view-order_list','sys_module_id'=>4],
          ['slug' => 'edit-order_list','sys_module_id'=>4],
          ['slug' => 'delete-order_list','sys_module_id'=>4],
          ['slug' => 'add-order_list','sys_module_id'=>4],

          ['slug' => 'view-quotation-list','sys_module_id'=>4],
          ['slug' => 'edit-quotation-list','sys_module_id'=>4],
          ['slug' => 'delete-quotation-list','sys_module_id'=>4],
          ['slug' => 'add-quotation-list','sys_module_id'=>4],

          ['slug' => 'view-cargo-list','sys_module_id'=>4],
          ['slug' => 'edit-cargo-list','sys_module_id'=>4],
          ['slug' => 'delete-cargo-list','sys_module_id'=>4],
          ['slug' => 'add-cargo-list','sys_module_id'=>4],

          ['slug' => 'view-cargo-client-list','sys_module_id'=>4],
          ['slug' => 'edit-cargo-client-list','sys_module_id'=>4],
          ['slug' => 'delete-cargo-client-list','sys_module_id'=>4],
          ['slug' => 'add-cargo-client-list','sys_module_id'=>4],

          ['slug' => 'view-cargo-quotation','sys_module_id'=>4],
          ['slug' => 'edit-cargo-quotation','sys_module_id'=>4],
          ['slug' => 'delete-cargo-quotation','sys_module_id'=>4],
          ['slug' => 'add-cargo-quotation','sys_module_id'=>4],

          ['slug' => 'view-cargo-invoice','sys_module_id'=>4],
          ['slug' => 'edit-cargo-invoice','sys_module_id'=>4],
          ['slug' => 'delete-cargo-invoice','sys_module_id'=>4],
          ['slug' => 'add-cargo-invoice','sys_module_id'=>4],

          ['slug' => 'view-cargo-mileage','sys_module_id'=>4],
          ['slug' => 'edit-cargo-mileage','sys_module_id'=>4],
          ['slug' => 'delete-cargo-mileage','sys_module_id'=>4],
          ['slug' => 'add-cargo-mileage','sys_module_id'=>4],

          ['slug' => 'view-cargo-collection','sys_module_id'=>4],
          ['slug' => 'edit-cargo-collection','sys_module_id'=>4],
          ['slug' => 'delete-cargo-collection','sys_module_id'=>4],
          ['slug' => 'add-cargo-collection','sys_module_id'=>4],

          ['slug' => 'view-cargo-loading','sys_module_id'=>4],
          ['slug' => 'edit-cargo-loading','sys_module_id'=>4],
          ['slug' => 'delete-cargo-loading','sys_module_id'=>4],
          ['slug' => 'add-cargo-loading','sys_module_id'=>4],

          
          ['slug' => 'view-cargo-offloading','sys_module_id'=>4],
          ['slug' => 'edit-cargo-offloading','sys_module_id'=>4],
          ['slug' => 'delete-cargo-offloading','sys_module_id'=>4],
          ['slug' => 'add-cargo-offloading','sys_module_id'=>4],

          ['slug' => 'view-cargo-delivering','sys_module_id'=>4],
          ['slug' => 'edit-cargo-delivering','sys_module_id'=>4],
          ['slug' => 'delete-cargo-delivering','sys_module_id'=>4],
          ['slug' => 'add-cargo-delivering','sys_module_id'=>4],

          ['slug' => 'view-cargo-activity','sys_module_id'=>4],
          ['slug' => 'edit-cargo-activity','sys_module_id'=>4],
          ['slug' => 'delete-cargo-activity','sys_module_id'=>4],
          ['slug' => 'add-cargo-activity','sys_module_id'=>4],

          ['slug' => 'view-cargo-order_report','sys_module_id'=>4],
          ['slug' => 'edit-cargo-order_report','sys_module_id'=>4],
          ['slug' => 'delete-cargo-order_report','sys_module_id'=>4],
          ['slug' => 'add-cargo-order_report','sys_module_id'=>4],

          ['slug' => 'view-cargo-truck_mileage','sys_module_id'=>4],
          ['slug' => 'edit-cargo-truck_mileage','sys_module_id'=>4],
          ['slug' => 'delete-cargo-truck_mileage','sys_module_id'=>4],
          ['slug' => 'add-cargo-truck_mileage','sys_module_id'=>4],
          
          // end manage-request permissions
        
          #2.start manage-warehouse permissions
          ['slug' => 'view-warehouse','sys_module_id'=>5],
          ['slug' => 'edit-warehouse','sys_module_id'=>5],
          ['slug' => 'delete-warehouse','sys_module_id'=>5],
          ['slug' => 'add-warehouse','sys_module_id'=>5],
          
          // end manage-request permissions

              #2.start manage-shop permissions
              ['slug' => 'view-supplier','sys_module_id'=>6],
              ['slug' => 'edit-supplier','sys_module_id'=>6],
              ['slug' => 'delete-supplier','sys_module_id'=>6],
              ['slug' => 'add-supplier','sys_module_id'=>6],

              ['slug' => 'view-product','sys_module_id'=>6],
              ['slug' => 'edit-product','sys_module_id'=>6],
              ['slug' => 'delete-product','sys_module_id'=>6],
              ['slug' => 'add-product','sys_module_id'=>6],

              ['slug' => 'view-purchase','sys_module_id'=>6],
              ['slug' => 'edit-purchase','sys_module_id'=>6],
              ['slug' => 'delete-purchase','sys_module_id'=>6],
              ['slug' => 'add-purchase','sys_module_id'=>6],

              ['slug' => 'view-sales','sys_module_id'=>6],
              ['slug' => 'edit-sales','sys_module_id'=>6],
              ['slug' => 'delete-sales','sys_module_id'=>6],
              ['slug' => 'add-sales','sys_module_id'=>6],
              
             
              // end manage-request permissions

       

            

           

            #3.start manage-AccessControl permissions  
            ['slug' => 'view-roles','sys_module_id'=>8],
            ['slug' => 'add-roles','sys_module_id'=>8],
            ['slug' => 'edit-roles','sys_module_id'=>8],
            ['slug' => 'delete-roles','sys_module_id'=>8],

            ['slug' => 'view-permission','sys_module_id'=>8],
            ['slug' => 'add-permission','sys_module_id'=>8],
            ['slug' => 'edit-permission','sys_module_id'=>8],
            ['slug' => 'delete-permission','sys_module_id'=>8],

            ['slug' => 'view-user','sys_module_id'=>8],
            ['slug' => 'add-user','sys_module_id'=>8],
            ['slug' => 'edit-user','sys_module_id'=>8],
            ['slug' => 'delete-user','sys_module_id'=>8],

            ['slug' => 'view-dashboard','sys_module_id'=>8],
            

            

             // end manage-AccessControl permissions 

             #4.start manage-Courier permissions  
            ['slug' => 'view-courier_list','sys_module_id'=>17],
            ['slug' => 'add-courier_list','sys_module_id'=>17],
            ['slug' => 'edit-courier_list','sys_module_id'=>17],
            ['slug' => 'delete-courier_list','sys_module_id'=>17],

            ['slug' => 'view-courier_quotation','sys_module_id'=>17],
            ['slug' => 'add-courier_quotation','sys_module_id'=>17],
            ['slug' => 'edit-courier_quotation','sys_module_id'=>17],
            ['slug' => 'delete-courier_quotation','sys_module_id'=>17],

            ['slug' => 'view-courier_invoice','sys_module_id'=>17],
            ['slug' => 'add-courier_invoice','sys_module_id'=>17],
            ['slug' => 'edit-courier_invoice','sys_module_id'=>17],
            ['slug' => 'delete-courier_invoice','sys_module_id'=>17],


            ['slug' => 'view-courier_collection','sys_module_id'=>17],
            ['slug' => 'add-courier_collection','sys_module_id'=>17],
            ['slug' => 'edit-courier_collection','sys_module_id'=>17],
            ['slug' => 'delete-courier_collection','sys_module_id'=>17],

            ['slug' => 'view-courier_loading','sys_module_id'=>17],
            ['slug' => 'add-courier_loading','sys_module_id'=>17],
            ['slug' => 'edit-courier_loading','sys_module_id'=>17],
            ['slug' => 'delete-courier_loading','sys_module_id'=>17],

            ['slug' => 'view-courier_offloading','sys_module_id'=>17],
            ['slug' => 'add-courier_offloading','sys_module_id'=>17],
            ['slug' => 'edit-courier_offloading','sys_module_id'=>17],
            ['slug' => 'delete-courier_offloading','sys_module_id'=>17],

            ['slug' => 'view-courier_delivering','sys_module_id'=>17],
            ['slug' => 'add-courier_delivering','sys_module_id'=>17],
            ['slug' => 'edit-courier_delivering','sys_module_id'=>17],
            ['slug' => 'delete-courier_delivering','sys_module_id'=>17],

            ['slug' => 'view-courier_activity','sys_module_id'=>17],
            ['slug' => 'add-courier_activity','sys_module_id'=>17],
            ['slug' => 'edit-courier_activity','sys_module_id'=>17],
            ['slug' => 'delete-courier_activity','sys_module_id'=>17],

            ['slug' => 'view-courier_report','sys_module_id'=>17],
            ['slug' => 'add-courier_report','sys_module_id'=>17],
            ['slug' => 'edit-courier_report','sys_module_id'=>17],
            ['slug' => 'delete-courier_report','sys_module_id'=>17],

             // end manage-courier permissions 
            

               #5.start manage-Payroll permissions  
            ['slug' => 'view-salary_template','sys_module_id'=>16],
            ['slug' => 'add-salary_template','sys_module_id'=>16],
            ['slug' => 'edit-salary_template','sys_module_id'=>16],
            ['slug' => 'delete-salary_template','sys_module_id'=>16],

            ['slug' => 'view-manage_salary','sys_module_id'=>16],
            ['slug' => 'add-manage_salary','sys_module_id'=>16],
            ['slug' => 'edit-manage_salary','sys_module_id'=>16],
            ['slug' => 'delete-manage_salary','sys_module_id'=>16],

            ['slug' => 'view-employee_salary_list','sys_module_id'=>16],
            ['slug' => 'add-employee_salary_list','sys_module_id'=>16],
            ['slug' => 'edit-employee_salary_list','sys_module_id'=>16],
            ['slug' => 'delete-employee_salary_list','sys_module_id'=>16],


            ['slug' => 'view-make_payment','sys_module_id'=>16],
            ['slug' => 'add-make_payment','sys_module_id'=>16],
            ['slug' => 'edit-make_payment','sys_module_id'=>16],
            ['slug' => 'delete-make_payment','sys_module_id'=>16],

            ['slug' => 'view-generate_payslip','sys_module_id'=>16],
            ['slug' => 'add-generate_payslip','sys_module_id'=>16],
            ['slug' => 'edit-generate_payslip','sys_module_id'=>16],
            ['slug' => 'delete-generate_payslip','sys_module_id'=>16],

            ['slug' => 'view-payroll_summary','sys_module_id'=>16],
            ['slug' => 'add-payroll_summary','sys_module_id'=>16],
            ['slug' => 'edit-payroll_summary','sys_module_id'=>16],
            ['slug' => 'delete-payroll_summary','sys_module_id'=>16],

            ['slug' => 'view-advance_salary','sys_module_id'=>16],
            ['slug' => 'add-advance_salary','sys_module_id'=>16],
            ['slug' => 'edit-advance_salary','sys_module_id'=>16],
            ['slug' => 'delete-advance_salary','sys_module_id'=>16],

            ['slug' => 'view-employee_loan','sys_module_id'=>16],
            ['slug' => 'add-employee_loan','sys_module_id'=>16],
            ['slug' => 'edit-employee_loan','sys_module_id'=>16],
            ['slug' => 'delete-employee_loan','sys_module_id'=>16],

            ['slug' => 'view-overtime','sys_module_id'=>16],
            ['slug' => 'add-overtime','sys_module_id'=>16],
            ['slug' => 'edit-overtime','sys_module_id'=>16],
            ['slug' => 'delete-overtime','sys_module_id'=>16],


            ['slug' => 'view-nssf','sys_module_id'=>16],
            ['slug' => 'add-nssf','sys_module_id'=>16],
            ['slug' => 'edit-nssf','sys_module_id'=>16],
            ['slug' => 'delete-nssf','sys_module_id'=>16],

            ['slug' => 'view-tax','sys_module_id'=>16],
            ['slug' => 'add-tax','sys_module_id'=>16],
            ['slug' => 'edit-tax','sys_module_id'=>16],
            ['slug' => 'delete-tax','sys_module_id'=>16],

            ['slug' => 'view-nhif','sys_module_id'=>16],
            ['slug' => 'add-nhif','sys_module_id'=>16],
            ['slug' => 'edit-nhif','sys_module_id'=>16],
            ['slug' => 'delete-nhif','sys_module_id'=>16],

            ['slug' => 'view-wcf','sys_module_id'=>16],
            ['slug' => 'add-wcf','sys_module_id'=>16],
            ['slug' => 'edit-wcf','sys_module_id'=>16],
            ['slug' => 'delete-wcf','sys_module_id'=>16],

            // end manage-payroll permissions 

            // end manage-leave permissions 
            ['slug' => 'view-leave','sys_module_id'=>12],
            ['slug' => 'add-leave','sys_module_id'=>12],
            ['slug' => 'edit-leave','sys_module_id'=>12],
            ['slug' => 'delete-leave','sys_module_id'=>12],
// end manage-payroll permissions 
// start manage-training permissions 
            ['slug' => 'view-training','sys_module_id'=>13],
            ['slug' => 'add-training','sys_module_id'=>13],
            ['slug' => 'edit-training','sys_module_id'=>13],
            ['slug' => 'delete-training','sys_module_id'=>13],
// end  manage-training permissions 
             

             // start manage-logistic permissions 
             ['slug' => 'view-truck','sys_module_id'=>15],
             ['slug' => 'add-truck','sys_module_id'=>15],
             ['slug' => 'edit-truck','sys_module_id'=>15],
             ['slug' => 'delete-truck','sys_module_id'=>15],
 
             ['slug' => 'view-driver','sys_module_id'=>15],
             ['slug' => 'add-driver','sys_module_id'=>15],
             ['slug' => 'edit-driver','sys_module_id'=>15],
             ['slug' => 'delete-driver','sys_module_id'=>15],
 
             ['slug' => 'view-fuel','sys_module_id'=>15],
             ['slug' => 'add-fuel','sys_module_id'=>15],
             ['slug' => 'edit-fuel','sys_module_id'=>15],
             ['slug' => 'delete-fuel','sys_module_id'=>15],
 
              // end manage-logistic permissions 

                 // start manage-inventory permissions 
             ['slug' => 'view-tyre_brand','sys_module_id'=>14],
             ['slug' => 'add-tyre_brand','sys_module_id'=>14],
             ['slug' => 'edit-tyre_brand','sys_module_id'=>14],
             ['slug' => 'delete-tyre_brand','sys_module_id'=>14],
 
             ['slug' => 'view-purchase_tyre','sys_module_id'=>14],
             ['slug' => 'add-purchase_tyre','sys_module_id'=>14],
             ['slug' => 'edit-purchase_tyre','sys_module_id'=>14],
             ['slug' => 'delete-purchase_tyre','sys_module_id'=>14],
 
             ['slug' => 'view-tyre_list','sys_module_id'=>14],
             ['slug' => 'add-tyre_list','sys_module_id'=>14],
             ['slug' => 'edit-tyre_list','sys_module_id'=>14],
             ['slug' => 'delete-tyre_list','sys_module_id'=>14],

             ['slug' => 'view-assign_truck','sys_module_id'=>14],
             ['slug' => 'add-assign_truck','sys_module_id'=>14],
             ['slug' => 'edit-assign_truck','sys_module_id'=>14],
             ['slug' => 'delete-assign_truck','sys_module_id'=>14],
 
             ['slug' => 'view-tyre_return','sys_module_id'=>14],
             ['slug' => 'add-tyre_return','sys_module_id'=>14],
             ['slug' => 'edit-tyre_return','sys_module_id'=>14],
             ['slug' => 'delete-tyre_return','sys_module_id'=>14],
 
             ['slug' => 'view-tyre_reallocation','sys_module_id'=>14],
             ['slug' => 'add-tyre_reallocation','sys_module_id'=>14],
             ['slug' => 'edit-tyre_reallocation','sys_module_id'=>14],
             ['slug' => 'delete-tyre_reallocation','sys_module_id'=>14],

             ['slug' => 'view-tyre_disposal','sys_module_id'=>14],
             ['slug' => 'add-tyre_disposal','sys_module_id'=>14],
             ['slug' => 'edit-tyre_disposal','sys_module_id'=>14],
             ['slug' => 'delete-tyre_disposal','sys_module_id'=>14],


             ['slug' => 'view-location','sys_module_id'=>14],
             ['slug' => 'add-location','sys_module_id'=>14],
             ['slug' => 'edit-location','sys_module_id'=>14],
             ['slug' => 'delete-location','sys_module_id'=>14],
 
             ['slug' => 'view-inventory','sys_module_id'=>14],
             ['slug' => 'add-inventory','sys_module_id'=>14],
             ['slug' => 'edit-inventory','sys_module_id'=>14],
             ['slug' => 'delete-inventory','sys_module_id'=>14],

             ['slug' => 'view-fieldstaff','sys_module_id'=>14],
             ['slug' => 'add-fieldstaff','sys_module_id'=>14],
             ['slug' => 'edit-fieldstaff','sys_module_id'=>14],
             ['slug' => 'delete-fieldstaff','sys_module_id'=>14],


             ['slug' => 'view-purchase_inventory','sys_module_id'=>14],
             ['slug' => 'add-purchase_inventory','sys_module_id'=>14],
             ['slug' => 'edit-purchase_inventory','sys_module_id'=>14],
             ['slug' => 'delete-purchase_inventory','sys_module_id'=>14],
 
             ['slug' => 'view-inventory_list','sys_module_id'=>14],
             ['slug' => 'add-inventory_list','sys_module_id'=>14],
             ['slug' => 'edit-inventory_list','sys_module_id'=>14],
             ['slug' => 'delete-inventory_list','sys_module_id'=>14],

             ['slug' => 'view-maintainance','sys_module_id'=>14],
             ['slug' => 'add-maintainance','sys_module_id'=>14],
             ['slug' => 'edit-maintainance','sys_module_id'=>14],
             ['slug' => 'delete-maintainance','sys_module_id'=>14],


             ['slug' => 'view-service','sys_module_id'=>14],
             ['slug' => 'add-service','sys_module_id'=>14],
             ['slug' => 'edit-service','sys_module_id'=>14],
             ['slug' => 'delete-service','sys_module_id'=>14],
 
             ['slug' => 'view-good_issue','sys_module_id'=>14],
             ['slug' => 'add-good_issue','sys_module_id'=>14],
             ['slug' => 'edit-good_issue','sys_module_id'=>14],
             ['slug' => 'delete-good_issue','sys_module_id'=>14],

             ['slug' => 'view-good_return','sys_module_id'=>14],
             ['slug' => 'add-good_return','sys_module_id'=>14],
             ['slug' => 'edit-good_return','sys_module_id'=>14],
             ['slug' => 'delete-good_return','sys_module_id'=>14],

             ['slug' => 'view-good_movement','sys_module_id'=>14],
             ['slug' => 'add-good_movement','sys_module_id'=>14],
             ['slug' => 'edit-good_movement','sys_module_id'=>14],
             ['slug' => 'delete-good_movement','sys_module_id'=>14],
 
             ['slug' => 'view-good_reallocation','sys_module_id'=>14],
             ['slug' => 'add-good_reallocation','sys_module_id'=>14],
             ['slug' => 'edit-good_reallocation','sys_module_id'=>14],
             ['slug' => 'delete-good_reallocation','sys_module_id'=>14],

             ['slug' => 'view-good_disposal','sys_module_id'=>14],
             ['slug' => 'add-good_disposal','sys_module_id'=>14],
             ['slug' => 'edit-good_disposal','sys_module_id'=>14],
             ['slug' => 'delete-good_disposal','sys_module_id'=>14],
 
              // end manage-payroll permissions 


              // start manage-transaction permissions 
             ['slug' => 'view-deposit','sys_module_id'=>11],
             ['slug' => 'add-deposit','sys_module_id'=>11],
             ['slug' => 'edit-deposit','sys_module_id'=>11],
             ['slug' => 'delete-deposit','sys_module_id'=>11],
 
             ['slug' => 'view-expenses','sys_module_id'=>11],
             ['slug' => 'add-expenses','sys_module_id'=>11],
             ['slug' => 'edit-expenses','sys_module_id'=>11],
             ['slug' => 'delete-expenses','sys_module_id'=>11],
 
             ['slug' => 'view-bank_statement','sys_module_id'=>11],
             ['slug' => 'add-bank_statement','sys_module_id'=>11],
             ['slug' => 'edit-bank_statement','sys_module_id'=>11],
             ['slug' => 'delete-bank_statement','sys_module_id'=>11],


             ['slug' => 'view-bank_reconciliation','sys_module_id'=>11],
             ['slug' => 'add-bank_reconciliation','sys_module_id'=>11],
             ['slug' => 'edit-bank_reconciliation','sys_module_id'=>11],
             ['slug' => 'delete-bank_reconciliation','sys_module_id'=>11],
             
             ['slug' => 'view-reconciliation_report','sys_module_id'=>11],
             ['slug' => 'add-reconciliation_report','sys_module_id'=>11],
             ['slug' => 'edit-reconciliation_report','sys_module_id'=>11],
             ['slug' => 'delete-reconciliation_report','sys_module_id'=>11],
              // end manage-transaction permissions 

              
              // start manage-gl-setup permissions 
             ['slug' => 'view-class_account','sys_module_id'=>10],
             ['slug' => 'add-class_account','sys_module_id'=>10],
             ['slug' => 'edit-class_account','sys_module_id'=>10],
             ['slug' => 'delete-class_account','sys_module_id'=>10],
 
             ['slug' => 'view-group_account','sys_module_id'=>10],
             ['slug' => 'add-group_account','sys_module_id'=>10],
             ['slug' => 'edit-group_account','sys_module_id'=>10],
             ['slug' => 'delete-group_account','sys_module_id'=>10],
 
             ['slug' => 'view-account_codes','sys_module_id'=>10],
             ['slug' => 'add-account_codes','sys_module_id'=>10],
             ['slug' => 'edit-account_codes','sys_module_id'=>10],
             ['slug' => 'delete-account_codes','sys_module_id'=>10],


             ['slug' => 'view-chart_of_account','sys_module_id'=>10],
             ['slug' => 'add-chart_of_account','sys_module_id'=>10],
             ['slug' => 'edit-chart_of_account','sys_module_id'=>10],
             ['slug' => 'delete-chart_of_account','sys_module_id'=>10],
             
            


 
              // end manage-gl-setup permissions



                            // start manage-accounting permissions 
             ['slug' => 'view-manual_entry','sys_module_id'=>9],
             ['slug' => 'add-manual_entry','sys_module_id'=>9],
             ['slug' => 'edit-manual_entry','sys_module_id'=>9],
             ['slug' => 'delete-manual_entry','sys_module_id'=>9],
 
             ['slug' => 'view-journal','sys_module_id'=>9],
             ['slug' => 'add-journal','sys_module_id'=>9],
             ['slug' => 'edit-journal','sys_module_id'=>9],
             ['slug' => 'delete-journal','sys_module_id'=>9],
 
             ['slug' => 'view-ledger','sys_module_id'=>9],
             ['slug' => 'add-ledger','sys_module_id'=>9],
             ['slug' => 'edit-ledger','sys_module_id'=>9],
             ['slug' => 'delete-ledger','sys_module_id'=>9],


             ['slug' => 'view-trial_balance','sys_module_id'=>9],
             ['slug' => 'add-trial_balance','sys_module_id'=>9],
             ['slug' => 'edit-trial_balance','sys_module_id'=>9],
             ['slug' => 'delete-trial_balance','sys_module_id'=>9],

             ['slug' => 'view-income_statement','sys_module_id'=>9],
             ['slug' => 'add-income_statement','sys_module_id'=>9],
             ['slug' => 'edit-income_statement','sys_module_id'=>9],
             ['slug' => 'delete-income_statement','sys_module_id'=>9],

             ['slug' => 'view-balance_sheet','sys_module_id'=>9],
             ['slug' => 'add-balance_sheet','sys_module_id'=>9],
             ['slug' => 'edit-balance_sheet','sys_module_id'=>9],
             ['slug' => 'delete-balance_sheet','sys_module_id'=>9],
             
            


 
              // end manage-accounting permissions

  
            
            
       ];

         foreach ($data as $row) {
            Permission::firstOrCreate($row);
         }
    }
}
