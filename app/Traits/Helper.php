<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use NumberFormatter;

trait Helper
{
    protected function calculateTotalAmount($data) {
        $totalAmount = 0;

        foreach($data->WorkOrderItems as $workOrderItem) {
            $totalAmount = $totalAmount + $workOrderItem->rate * $workOrderItem->quantity;
        }

        return $totalAmount;
    }

    protected function calculatePaidAmount($data) {
        $totalAmount = 0;

        foreach($data->RAs as $RA) {
//            $totalAmount = $totalAmount + $RA->amount;
            $totalAmount = $totalAmount + $RA->RADetails->sum('amount');
        }

        return $totalAmount;
    }

    protected function calculateRemainingAmount($data) {
        $remainingAmount = $this->calculateTotalAmount($data) - $this->calculatePaidAmount($data);
        return $remainingAmount;
    }

    protected function calculateRemainingAmountPercentage($data) {
        $totalAmount = $this->calculateTotalAmount($data);
        $remainingAmount = $this->calculateRemainingAmount($data);

        if($totalAmount > 0){
            return ($remainingAmount * 100) / $totalAmount;
        }else{
            return 0;
        }

    }

    protected function calculateQty($ras) {
        $quantity = 0;
        foreach($ras as $workRA) {
            $quantity = $quantity + $this->convert_qty($workRA->quantity);
        }
        return $quantity;
    }

    private function convert_qty($qty) {
        $qtyArray = explode("%", $qty);
        if(count($qtyArray) === 2) {
            $qty = $qtyArray[0] / 100;
        }
        return $qty;
    }

    public static function  formatAmount($amount) {
        $fmt = numfmt_create( 'en_IN', NumberFormatter::CURRENCY, NumberFormatter::CURRENCY_CODE  );
        $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, "");

        $value = explode(".",strval($amount));
        if(count($value) > 1) {
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);
        } else {
            $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
        }
        return (numfmt_format_currency($fmt, $amount, "INR"));
    }

    public function calculateWorkBalance($items) {
        $workOrderBalance = [];
        $paymentAllowsAsPerRPF = 0;
		$proposedBillingBreakup = 0;

        foreach($items as $item) {
            $totalAmount = $this->getTotalItemRate($item);
            $itemQuantity = $item->quantity;

            foreach($item->ItemDetailsParent as $ItemDetailsParent) {
                $paymentAllowsAsPerRPF = ($totalAmount*$ItemDetailsParent->percentage)/100;

                foreach ($ItemDetailsParent->ItemDetailChilds as $ItemDetailChild) {
                    // $proposedBillingBreakup = ($paymentAllowsAsPerRPF*$ItemDetailChild->percentage)/100;
                    $proposedBillingBreakup = ($totalAmount*$ItemDetailChild->percentage)/100;
//                    $proposedBillingBreakupQuantity = ($itemQuantity * $ItemDetailChild->percentage)/100;
                    $proposedBillingBreakupQuantity = $itemQuantity;

                    $workOrderBalance[$ItemDetailChild->id]['amount'] = ($proposedBillingBreakup);
                    $workOrderBalance[$ItemDetailChild->id]['quantity'] = ($proposedBillingBreakupQuantity);
                }
            }
        }

        return $workOrderBalance;
    }

    public function getTotalItemRate($item) {
        return $item->quantity*$item->rate;
    }

    public function getShortedItemWithChildItems($items){
        $shotedItems = [];

        foreach( $items as $item){
			array_push($shotedItems, $item);
			if (isset($item->ChildItems) && $item->ChildItems->count() > 0) {
				foreach($item->ChildItems as $subItem){
					array_push($shotedItems, $subItem);

					if (isset($subItem->ChildItems) && $subItem->ChildItems->count() > 0) {
						foreach($subItem->ChildItems as $subSubItem){
							array_push($shotedItems, $subSubItem);
						}
					}
				}
			}
		}

        return $shotedItems;
    }
}
