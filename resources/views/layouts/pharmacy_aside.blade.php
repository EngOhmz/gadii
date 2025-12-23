@can('view-supplier')
                 
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ (request()->is('pos/pharmacy_sales/*')) ? 'active' : ''  }}"><i
                            class="icon-basket"></i> <span>Pharmacy Sales
                        </span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_sales/pharmacy_client*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_sales/pharmacy_client')}}"><i></i></i>Clients List</a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_sales/pharmacy_invoice*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_sales/pharmacy_invoice')}}"><i></i></i>Invoices</a></li>
                      <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_sales/pharmacy_debtors_report*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_sales/pharmacy_debtors_report')}}"><i></i></i>Debtors Report</a></li>
                         <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_sales/pharmacy_credit_note*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_sales/pharmacy_credit_note')}}"><i></i></i>Credit Note</a></li>
                       <!-- <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_sales/payments*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_sales/payments')}}"><i></i></i>Manage Payments</a></li> -->
                
                    </ul>
                    </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ (request()->is('pos/pharmacy_purchases/*')) ? 'active' : ''  }}"><i
                            class="icon-basket"></i> <span>Pharmacy Purchases
                        </span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_purchases/pharmacy_items*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_purchases/pharmacy_items')}}"><i></i></i>Manage Drugs</a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_purchases/pharmacy_supplier*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_purchases/pharmacy_supplier')}}"><i></i></i>Manage Suppliers</a></li>
                        <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_purchases/pharmacy_purchase*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_purchases/pharmacy_purchase')}}"><i></i></i>Manage Purchases</a></li>
                              <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_purchases/pharmacy_creditors_report*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_purchases/pharmacy_creditors_report')}}"><i></i></i>Creditors Report</a></li>
                    <!--    <li class="nav-item"><a class="nav-link {{ (request()->is('pos/pharmacy_purchases/pharmacy_payments*')) ? 'active' : ''  }}"
                        href="{{url('pos/pharmacy_purchases/pharmacy_payments')}}"><i></i></i>Manage Payments</a></li> -->
                
                    </ul>
                    </li>
              

                @endcan