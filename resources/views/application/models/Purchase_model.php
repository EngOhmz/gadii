<?php

/**
 * Description of purchase_model
 *
 * @author NaYeM
 */
class Purchase_model extends MY_Model
{

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_payment_status($purchase_id, $unmark = null)
    {
        if (!empty($purchase_id)) {
            $tax = $this->get_purchase_tax_amount($purchase_id);
            $discount = $this->get_purchase_discount($purchase_id);
            $invoice_cost = $this->get_purchase_cost($purchase_id);
            $payment_made = round($this->get_purchase_paid_amount($purchase_id), 2);
            $due = round(((($invoice_cost - $discount) + $tax) - $payment_made));
            $purchase_info = $this->check_by(array('purchase_id' => $purchase_id), 'tbl_purchases');
            if ($purchase_info->status == 'Cancelled' && empty($unmark)) {
                return ('cancelled');
            } elseif ($payment_made < 1) {
                return ('not_paid');
            } elseif ($due <= 0) {
                return ('fully_paid');
            } else {
                return ('partially_paid');
            }
        }
    }

    function calculate_to($value, $purchase_id)
    {
        switch ($value) {
            case 'purchase_cost':
                return $this->get_purchase_cost($purchase_id);
                break;
            case 'tax':
                return $this->get_purchase_tax_amount($purchase_id);
                break;
            case 'discount':
                return $this->get_purchase_discount($purchase_id);
                break;
            case 'paid_amount':
                return $this->get_purchase_paid_amount($purchase_id);
                break;
            case 'purchase_due':
                return $this->get_purchase_due_amount($purchase_id);
                break;
            case 'total':
                return $this->get_purchase_total_amount($purchase_id);
                break;
        }
    }

    function get_purchase_cost($purchase_id)
    {
        $this->db->select_sum('total_cost');
        $this->db->where('purchase_id', $purchase_id);
        $this->db->from('tbl_purchase_items');
        $query_result = $this->db->get();
        $cost = $query_result->row();
        if (!empty($cost->total_cost)) {
            $result = $cost->total_cost;
        } else {
            $result = '0';
        }
        return $result;
    }

    public function get_purchase_tax_amount($purchase_id)
    {
        $purchase_info = $this->check_by(array('purchase_id' => $purchase_id), 'tbl_purchases');
        if (!empty($purchase_info->total_tax)) {
            $tax_info = json_decode($purchase_info->total_tax);
        }
        $tax = 0;
        if (!empty($tax_info)) {
            $total_tax = $tax_info->total_tax;
            if (!empty($total_tax)) {
                foreach ($total_tax as $t_key => $v_tax_info) {
                    $tax += $v_tax_info;
                }
            }
        }
        return $tax;
    }

    public function get_purchase_discount($purchase_id)
    {
        $purchase_info = $this->check_by(array('purchase_id' => $purchase_id), 'tbl_purchases');
        if (!empty($purchase_info)) {
            return $purchase_info->discount_total;
        }

    }

    public function get_purchase_paid_amount($purchase_id)
    {

        $this->db->select_sum('amount');
        $this->db->where('purchase_id', $purchase_id);
        $this->db->from('tbl_purchase_payments');
        $query_result = $this->db->get();
        $amount = $query_result->row();
//        $tax = $this->get_purchase_tax_amount($purchase_id);
        if (!empty($amount->amount)) {
            $result = $amount->amount;
        } else {
            $result = '0';
        }
        return $result;
    }

    public function get_purchase_due_amount($purchase_id)
    {

        $purchase_info = $this->check_by(array('purchase_id' => $purchase_id), 'tbl_purchases');
        if (!empty($purchase_info)) {
            $tax = $this->get_purchase_tax_amount($purchase_id);
            $discount = $this->get_purchase_discount($purchase_id);
            $purchase_cost = $this->get_purchase_cost($purchase_id);
            $payment_made = $this->get_purchase_paid_amount($purchase_id);
            $due_amount = (($purchase_cost - $discount) + $tax) - $payment_made + $purchase_info->adjustment;
            if ($due_amount <= 0) {
                $due_amount = 0;
            }
        } else {
            $due_amount = 0;
        }
        return $due_amount;
    }

    public function get_purchase_total_amount($purchase_id)
    {

        $purchase_info = $this->check_by(array('purchase_id' => $purchase_id), 'tbl_purchases');
        $tax = $this->get_purchase_tax_amount($purchase_id);
        $discount = $this->get_purchase_discount($purchase_id);
        $purchase_cost = $this->get_purchase_cost($purchase_id);
//        $payment_made = $this->get_purchase_paid_amount($purchase_id);

        $total_amount = $purchase_cost - $discount + $tax + $purchase_info->adjustment;
        if ($total_amount <= 0) {
            $total_amount = 0;
        }
        return $total_amount;
    }

    function ordered_items_by_id($id, $json = null)
    {
        $rows = $this->db->where('purchase_id', $id)->order_by('order', 'asc')->get('tbl_purchase_items')->result();
        if (!empty($json)) {
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $row->qty = $row->quantity;
                    $row->rate = $row->unit_cost;
                    $row->cost_price = $row->unit_cost;
                    $row->new_itmes_id = $row->saved_items_id;
                    $row->taxname = $this->get_invoice_item_taxes($row->items_id, 'purchase');;
                    $pr[$row->saved_items_id] = $row;
                }
                return json_encode($pr);
            }
        } else {
            return $rows;
        }
    }


}


    public function purchase_payable($id)
    {
        return ($this->get_purchase_cost($id) + $this->get_purchase_tax_amount($id) - $this->get_purchase_discount($id));
    }

/*********************************************************/

 public function get_purchase_report($filterBy = null, $range = null)
    {
        if (!empty($filterBy) && is_numeric($filterBy)) {
            $purchase = $this->db->where('supplier_id', $filterBy)->get('tbl_purchases')->result();
        } else {
            $all_data = $this->get_permission('tbl_purchases');
        }
        if (empty($filterBy) || !empty($filterBy) && $filterBy == 'all') {
            $purchase = $all_data;
        } elseif ($filterBy == 'recurring') {
            $purchase = $this->recurring_invoices();
        } else {
            if (!empty($all_data)) {
                $all_data = array_reverse($all_data);
                foreach ($all_data as $v_purchases) {
                    if ($filterBy == 'paid') {
                        if ($this->get_payment_status($v_purchases->purchase_id) == lang('fully_paid')) {
                            $purchase[] = $v_purchases;
                        }
                    } else if ($filterBy == 'not_paid') {
                        if ($this->get_payment_status($v_purchases->purchase_id) == lang('not_paid')) {
                            $purchase[] = $v_purchases;
                        }
                    } else if ($filterBy == 'draft') {
                        if ($this->get_payment_status($v_purchases->purchase_id) == lang('draft')) {
                            $purchase[] = $v_purchases;
                        }
                    } else if ($filterBy == 'partially_paid') {
                        if ($this->get_payment_status($v_purchases->purchase_id) == lang('partially_paid')) {
                            $purchase[] = $v_purchases;
                        }
                    } else if ($filterBy == 'cancelled') {
                        if ($this->get_payment_status($v_purchases->purchase_id) == lang('cancelled')) {
                            $purchase[] = $v_purchases;
                        }
                    } else if ($filterBy == 'overdue') {
                        $payment_status = $this->get_payment_status($v_purchases->purchase_id);
                        if (strtotime($v_purchases->due_date) < strtotime(date('Y-m-d')) && $payment_status != lang('fully_paid')) {
                            $purchase[] = $v_purchases;
                        }
                    } else if ($filterBy == 'last_month' || $filterBy == 'this_months') {
                        if ($filterBy == 'last_month') {
                            $month = date('Y-m', strtotime('-1 months'));
                        } else {
                            $month = date('Y-m');
                        }
                        if (strtotime($v_purchases->purchase_month) == strtotime($month)) {
                            $purchase[] = $v_purchases;
                        }
                    } else if (strstr($filterBy, '_')) {
                        $year = str_replace('_', '', $filterBy);
                        if (strtotime($v_purchases->purchase_year) == strtotime($year)) {
                            $purchase[] = $v_purchases;
                        }
                    }
                }
            }
        }
        if (!empty($purchase)) {
            $purchases = array();

            if (!empty($range[0])) {
                foreach ($purchase as $v_purchases) {
                    if ($v_purchases->purchase_date >= $range[0] && $v_purchases->purchase_date <= $range[1]) {
                        array_push($purchase, $v_purchases);
                    }
                }
                return $purchases;
            } else {
                return $purchase;
            }
        } else {
            return array();
        }
    }
/*********************************************************/