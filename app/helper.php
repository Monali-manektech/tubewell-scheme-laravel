<?php

use App\Models\Item;
use App\Models\WorkOrderItems;
use App\Traits\Helper;

if(!function_exists('get_master_phase')) {
	function get_master_phase() {
		return \App\Models\MasterPhase::get();
	}
}

if(!function_exists('format_amount')) {
    function format_amount($amount) {
        $format_amount = Helper::formatAmount($amount);
		return $format_amount > 1 ? $format_amount : 0.00;
    }
}

if(!function_exists('get_empty_item')) {
    function get_empty_item() {
        $item = new Item;
        $item->ItemDetailChilds = collect([]);
        return $item;
    }
}

if(!function_exists('get_empty_workorder_item')) {
    function get_empty_workorder_item() {
        $item = new WorkOrderItems();
        $item->ItemDetailChilds = collect([]);
        return $item;
    }
}

if(!function_exists('balanceWorkDone')){
    function balanceWorkDone($itemChild, $workOrderBalance = []) {

    }
}
