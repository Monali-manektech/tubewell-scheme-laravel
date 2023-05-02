<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MasterPhase;
use App\Models\RaDetails;
use App\Models\WorkOrder;
use App\Models\WorkOrderItemDetail;
use App\Models\WorkOrderItems;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use App\Models\Legend;

class WorkOrderController extends Controller
{
	use Helper;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
	 */
	public function index(Request $request)
	{
		$title = "Work Orders";
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
			],
		];

		$master_phase_slug = !empty($request->master_phase) ? $request->master_phase : Session::get('master_phase_slug');

		if ($request->ajax()) {
			$workOrders = WorkOrder::query()->with('GramPanchayat', 'RAs', 'WorkOrderItems');

			$master_phase_slug = !empty($request->master_phase) ? $request->master_phase : 'master-phase-1';
			$workOrders = $workOrders->where('master_phase_slug' , $master_phase_slug);
			Session::put('master_phase_slug', $master_phase_slug);

			return DataTables::of($workOrders)
				->addIndexColumn()
				->editColumn('grampanchayat_id', function ($data) {
					return $data->GramPanchayat ? $data->GramPanchayat->name : null;
				})
				->addColumn('items', function ($data) {
					return count($data->WorkOrderItems);
				})
				->addColumn('total_amount', function ($data) {
					return  count($data->WorkOrderItems) !== 0 ? $this->formatAmount($this->calculateTotalAmount($data)) : 0;
				})
				->addColumn('paid_amount', function ($data) {
					return  count($data->RAs) !== 0 ? $this->formatAmount($this->calculatePaidAmount($data)) : 0;
				})
				->addColumn('remaining_amount', function ($data) {
					return  count($data->WorkOrderItems) !== 0 ? $this->formatAmount($this->calculateRemainingAmount($data)) : 0;
				})
				->addColumn('remaining_amount_percentage', function ($data) {
					return  count($data->WorkOrderItems) !== 0 ? $this->formatAmount($this->calculateRemainingAmountPercentage($data)) : 0;
				})
				->addColumn('action', function ($data) {
					return view('workorders._form_actions', compact('data'))->render();
				})
				->make();
		}
		$master_phases = MasterPhase::all();
		return view('workorders.index', compact('title', 'breadcrumb', 'master_phases', 'master_phase_slug'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create()
	{
		$master_phase = Session::get('master_phase_slug');
		$title = "Add New Work Order for " . $master_phase;
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
				'link' => route('work-orders.index'),
			],
			[
				'title' => "Add new Work Order",
			],
		];

		return view('workorders.create', compact('title', 'breadcrumb'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\WorkOrder  $workOrder
	 * @return \Illuminate\Contracts\View\View
	 */
	public function edit(WorkOrder $workOrder)
	{
		$master_phase = Session::get('master_phase_slug');
		$title = "Update Work Order for " . $master_phase;
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
				'link' => route('work-orders.index'),
			],
			[
				'title' => "Edit Work Order",
			],
		];

		return view('workorders.edit', compact('workOrder', 'title', 'breadcrumb'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\WorkOrder  $workOrder
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(WorkOrder $workOrder)
	{

		if (!empty($workOrder->WorkOrderItems) && $workOrder->WorkOrderItems->count() > 0) {
			foreach ($workOrder->WorkOrderItems as $workOrderItem) {

				if (!empty($workOrderItem->itemDetails) && $workOrderItem->itemDetails->count() > 0) {
					foreach ($workOrderItem->itemDetails as $workOrderItemDetail) {
						$workOrderItemDetail->delete();
					}
				}
				$workOrderItem->delete();
			}
		}
		$workOrder->delete();

		Session::flash('success', 'Work Order deleted successfully.');
		return redirect()->route('work-orders.index');
	}

	/**
	 * Link the items to the WorkOrder.
	 *
	 * @param  \App\Models\WorkOrder  $workOrder
	 * @return \Illuminate\Contracts\View\View
	 */

	public function linkItems(WorkOrder $workOrder)
	{
		$master_phase_slug = Session::get('master_phase_slug');
		$title = "Link Items for " . $master_phase_slug;
		$requested_legend = '';
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
				'link' => route('work-orders.index'),
			],
			[
				'title' => "Link Items",
			],
		];
		$shotedItems = [];

		$items = Item::
			withCount('ChildItems')
			->withCount('ItemDetailsParent')
			->with(['ItemDetailsParent' => function ($query) {
				$query->withCount('ItemDetailChilds');
			}, 'ItemDetailsParent.ItemDetailChilds', 'Unit', 'ChildItems.ChildItems.ChildItems'])
			->whereNull('parent_id')
			->where('master_phase_slug', $master_phase_slug)
			->get();

		$shotedItems = $this->getShortedItemWithChildItems($items);

		$workOrderItems = $workOrder->WorkOrderItems->map(function ($item) {

			$data = [
				'item_id' => $item->item_id,
				'item_no' => $item->item_no,
				'quantity' => $item->quantity,
				'rate' => $item->rate,
				'total_rate' => format_amount($item->quantity * $item->rate)
			];

			foreach ($item->itemDetails as $itemDetail) {

				$data['item_details'][] = [
					'item_detail_id' => $itemDetail->item_detail_id,
					'percentage' => $itemDetail->percentage,
					'due_amount' => format_amount(($item->quantity * $item->rate * $itemDetail->percentage) / 100)
				];
			}
			return $data;
		});
		$workOrderItems = $workOrderItems->toArray();
		$legends = Legend::where('master_phase_slug', $master_phase_slug)->whereNull('deleted_at')->get();
		$workOrder_id = $workOrder->id;
		return view('workorders.link-items', compact('workOrder', 'title', 'breadcrumb', 'items', 'workOrderItems', 'shotedItems','legends','requested_legend','workOrder_id'));
	}

	public function storeLinkItems(Request $request, WorkOrder $workOrder)
	{
		$selectedItems = collect($request->input('items'))->filter(function ($item) {
			if (isset($item['select'])) {
				return $item;
			}
		})->toArray();

		$previous_item_ids = $request->previous_item_ids ? explode(",", $request->previous_item_ids) : [];

		if (count($selectedItems) === 0 && count($previous_item_ids) === 0) {
			Session::flash('info', 'No Item selected. Please select least one item to proceed.');
			return redirect()->route('work-orders.index');
		}

		$addedItems = collect(array_keys($selectedItems ? $selectedItems : []))->filter(function ($item) use ($previous_item_ids) {
			return !in_array($item, $previous_item_ids);
		});

		// Remove the items and item details which are unselected.
		$master_phase_slug = Session::get('master_phase_slug');
		$removedItems = collect($previous_item_ids)->diff(array_keys($selectedItems ? $selectedItems : []));
		$previousWorkOrderItemsIds = WorkOrderItems::select('id')->where('master_phase_slug', $master_phase_slug)
			->whereIn('item_id', $removedItems)->get()->pluck('id')->toArray();

		$workOrderItemDetails = WorkOrderItemDetail::select('id', 'item_detail_id', 'work_order_items_id')
			->where('master_phase_slug', $master_phase_slug)->whereIn('work_order_items_id', $previousWorkOrderItemsIds)->get();

		foreach ($workOrderItemDetails as $workOrderItemDetail) {
			RaDetails::where('work_order_item_detail_id', $workOrderItemDetail->id)->delete();
			$workOrderItemDetail->delete();
		}
		WorkOrderItems::select('id')->whereIn('item_id', $removedItems)->delete();

		$itemsMaster = Item::with(['ItemDetailsParent', 'ItemDetailsParent.ItemDetailChilds'])->whereIn('id', $addedItems)
			->where('master_phase_slug', $master_phase_slug)->get();

		// Insert new selected Items into the database.
		foreach ($itemsMaster as $item) {
				$workorder_item = $item->replicate();

			$workorder_item->setTable('work_order_items');
			$workorder_item->work_order_id = $workOrder->id;
			$workorder_item->item_id = $item['id'];
			$workorder_item->quantity = $selectedItems[$item->id]['quantity'] ?? Null;
			$workorder_item->rate = $selectedItems[$item->id]['rate'] ?? Null;
			$workorder_item->master_phase_slug = $master_phase_slug;
			$workorder_item->save();

			if(count($item->ItemDetailsParent) > 0) {
				foreach ($item->ItemDetailsParent as $key => $itemDetail) {
					$workorder_itemdetail = $itemDetail->replicate(['item_id']);

					$workorder_itemdetail->setTable('work_order_item_details');
					$workorder_itemdetail->work_order_items_id = $workorder_item->id;
					$workorder_itemdetail->item_detail_id = $itemDetail->id;
					$workorder_itemdetail->master_phase_slug = $master_phase_slug;
					$workorder_itemdetail->save();

					if(count($itemDetail->ItemDetailChilds) > 0) {
						foreach ($itemDetail->ItemDetailChilds as $child) {

							$selectedItemsPaymentProposedPercentage = isset($selectedItems[$item->id]['payment_proposed'][$child->id]) ? $selectedItems[$item->id]['payment_proposed'][$child->id] : '';

							$workorder_itemdetail_child = $child->replicate(['item_id']);
							$workorder_itemdetail_child->setTable('work_order_item_details');
							$workorder_itemdetail_child->parent_id = $workorder_itemdetail->id;
							$workorder_itemdetail_child->work_order_items_id = $workorder_item->id;
							$workorder_itemdetail_child->item_detail_id = $child->id;
							$workorder_itemdetail_child->percentage = $selectedItemsPaymentProposedPercentage;
							$workorder_itemdetail_child->master_phase_slug = $master_phase_slug;
							$workorder_itemdetail_child->save();
						}
					} else {
						$workorder_itemdetail_child = new WorkOrderItemDetail;
						$workorder_itemdetail_child->work_order_items_id = $workorder_item->id;
						$workorder_itemdetail_child->name = "On completion of work";
						$workorder_itemdetail_child->parent_id = $workorder_itemdetail->id;
						$workorder_itemdetail_child->percentage = 100;
						$workorder_itemdetail_child->master_phase_slug = $master_phase_slug;
						$workorder_itemdetail_child->save();
					}
				}
			}
			// else {
			// 	// Create the WorkOrderItemDetails with parent and child with the 100% payment breakup if no payment breakup is defined in the main item
			// 	$workorder_itemdetail = new WorkOrderItemDetail;
			// 	$workorder_itemdetail->work_order_items_id = $workorder_item->id;
			// 	$workorder_itemdetail->name = "On completion of work";
			// 	$workorder_itemdetail->percentage = 100;
			// 	$workorder_itemdetail->save();

			// 	$workorder_itemdetail_child = new WorkOrderItemDetail;
			// 	$workorder_itemdetail_child->work_order_items_id = $workorder_item->id;
			// 	$workorder_itemdetail_child->name = "On completion of work";
			// 	$workorder_itemdetail_child->parent_id = $workorder_itemdetail->id;
			// 	$workorder_itemdetail_child->percentage = 100;
			// 	$workorder_itemdetail_child->save();
			// }
		}
		Session::flash('success', 'Items successfully linked to the work order.');
		return redirect()->route('work-orders.index');
	}

	public function linkRaDetails(WorkOrder $workOrder, $raID = null)
	{
		$master_phase_slug = Session::get('master_phase_slug');
		$workOrderRas = $workOrder->RAs->sortBy('id');
		$requested_legend = '';
		$title = "Link RA for " . $master_phase_slug;
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
				'link' => route('work-orders.index'),
			],
			[
				'title' => "Link Ra",
			],
		];

		$items = WorkOrderItems::withCount('ChildItems')
			->where('work_order_id', $workOrder->id)
			->withCount('ItemDetailsParent')
			->with(['ItemDetailsParent' => function ($query) {
				$query->withCount('ItemDetailChilds');
			}, 'ItemDetailsParent.ItemDetailChilds', 'Unit'])
			->where('master_phase_slug', $master_phase_slug)
//			->orderByRaw("CAST(item_no as UNSIGNED) ASC")
			->get();

		$items = $items->sortBy('item_order', true);

//		$workOrderItemIds = $items->pluck('item_id')->toArray();

		$shotedItems = [];
		$addedItemsIds = [];

		// $shotedItems = $this->getShortedItemWithChildItems($items->whereNull('parent_id'));

		$workOrderItemsID = $workOrder->WorkOrderItems->map(function ($item) {
			return $item->item_id;
		});
		$workOrderItemsID = $workOrderItemsID->toArray();


		$workOrderRasLink = [];
		$raDetail = RaDetails::where('work_order_id', $workOrder->id)->where('master_phase_slug', $master_phase_slug)
			->get()->groupBy('r_a_id');

		if (isset($raDetail) && !empty(collect($raDetail))) {
			foreach ($raDetail as $key => $ra) {
				$workOrderRasLink[$key] = $ra->keyBy('work_order_item_detail_id')->toArray();
			}
		}

		$workOrderRasQuantity = [];
		$workOrderRaDetail = RaDetails::where('work_order_id', $workOrder->id)->where('master_phase_slug', $master_phase_slug)
			->get()->groupBy('work_order_item_detail_id');

		if (isset($workOrderRaDetail) && !empty(collect($workOrderRaDetail))) {
			foreach ($workOrderRaDetail as $key => $work_order_ra) {
				$workOrderRasQuantity[$key]['quantity'] = $work_order_ra->sum('quantity');
				$workOrderRasQuantity[$key]['r_a_id'] = $work_order_ra->pluck('r_a_id')->toArray();
			}
		}
		$legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $master_phase_slug)->get();
		$workOrder_id = $workOrder->id;
		return view('workorders.link-ra-details', compact('workOrder', 'title', 'breadcrumb', 'workOrderItemsID', 'workOrderRas', 'workOrderRasLink', 'raID', 'items', 'shotedItems', 'legends','workOrder_id','requested_legend', 'workOrderRasQuantity'));
	}

	public function storeLinkRaDetails(Request $request, WorkOrder $workOrder)
	{
		if (!$request->ra) {
			Session::flash('info', 'There is no any data to save.');
			return redirect()->route('work-orders.linkRaDetails');
		}

		foreach ($request->ra as $ra_id => $item) {
			foreach ($item as $work_order_item_detail_id => $value) {
				$quantity = 0;
				if (isset($value['percentage']) && isset($value['amount'])) {
					$checkArr = [
						'r_a_id' => $ra_id,
						'work_order_item_detail_id' => $work_order_item_detail_id
					];

					if (isset($value['quantity'])) {
						$quantityArray = explode('%', $value['quantity']);
						if (count($quantityArray) === 2 && is_numeric($quantityArray[0]) && $quantityArray[1] === "") {
							$quantity = $value['quantity'];
						} elseif (is_numeric($value['quantity'])) {
							$quantity = $value['quantity'];
						}
					}
					//Log::info('$quantity' . $quantity);
					$master_phase_slug = Session::get('master_phase_slug');
					$updateArr = [
						'r_a_id' => $ra_id,
						'work_order_item_detail_id' => $work_order_item_detail_id,
						'work_order_id' => $workOrder->id,
						'quantity' => $quantity,
						'percentage' => $value['percentage'],
						'amount' => $value['amount'],
						'master_phase_slug' => $master_phase_slug
					];
					$update = RaDetails::updateOrCreate($checkArr, $updateArr);
					//Log::info('$update' . $update);
				}
			}
		}

		Session::flash('success', 'RA successfully linked with work order');
		return redirect()->back();
	}

	public function filterRAThroughLegend()
	{
		$workOrder_id = request()->workOrder_id;
		$legend = request()->legend;
		$requested_legend = $legend;
		$workOrder = WorkOrder::where('id', $workOrder_id)->first();
		$raID = null;
		$workOrderRas_arr = WorkOrder::where('id', $workOrder_id)->with('RAs')->orderBy('id','asc')->first();
		$workOrderRas_json = json_decode($workOrderRas_arr);
		$workOrderRas = $workOrderRas_json->r_as;
		$master_phase_slug = Session::get('master_phase_slug');
		$title = "Link RA for " . $master_phase_slug;
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
				'link' => route('work-orders.index'),
			],
			[
				'title' => "Link Ra",
			],
		];

		if (isset(request()->legend) && !empty(request()->legend)) {
			$items = WorkOrderItems::withCount('ChildItems')
				->where('work_order_id', $workOrder_id)
				->where('legend', $legend)
				->withCount('ItemDetailsParent')
				->with(['ItemDetailsParent' => function ($query) {
					$query->withCount('ItemDetailChilds');
				}, 'ItemDetailsParent.ItemDetailChilds', 'Unit'])
				->where('master_phase_slug', $master_phase_slug)
				->get();
		} else {
			$items = WorkOrderItems::withCount('ChildItems')
				->where('work_order_id', $workOrder_id)
				->withCount('ItemDetailsParent')
				->with(['ItemDetailsParent' => function ($query) {
					$query->withCount('ItemDetailChilds');
				}, 'ItemDetailsParent.ItemDetailChilds', 'Unit'])
				->where('master_phase_slug', $master_phase_slug)
				->get();
		}
		$workOrderItemIds = $items->pluck('item_id')->toArray();

		$shotedItems = [];
		$addedItemsIds = [];

		$workOrderItemsID = $workOrder->WorkOrderItems->map(function ($item) {
			return $item->item_id;
		});
		$workOrderItemsID = $workOrderItemsID->toArray();


		$workOrderRasLink = [];
		$raDetail = RaDetails::where('work_order_id', $workOrder_id)->where('master_phase_slug', $master_phase_slug)
			->get()->groupBy('r_a_id');

		if (isset($raDetail) && !empty(collect($raDetail))) {
			foreach ($raDetail as $key => $ra) {
				$workOrderRasLink[$key] = $ra->keyBy('work_order_item_detail_id')->toArray();
			}
		}
		$legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $master_phase_slug)->get();
		return view('workorders.link-ra-details', compact('workOrder', 'title', 'breadcrumb', 'workOrderItemsID', 'workOrderRas', 'workOrderRasLink', 'raID', 'items', 'shotedItems', 'legends','workOrder_id','requested_legend'));
	}

 	public function filterLinkItemThroughLegend()
	{
		$workOrder_id = request()->workOrder_id;
		$legend = request()->legend;
		$requested_legend = $legend;
		$workOrder = WorkOrder::where('id', $workOrder_id)->first();
		$master_phase_slug = Session::get('master_phase_slug');
		$title = "Link Items for " . $master_phase_slug;
		$breadcrumb = [
			[
				'title' => "Dashboard",
				'link' => route('admin.dashboard'),
			],
			[
				'title' => "Work Orders",
				'link' => route('work-orders.index'),
			],
			[
				'title' => "Link Items",
			],
		];
		$shotedItems = [];

		if (isset(request()->legend) && !empty(request()->legend)) {
			$items = Item::
			withCount('ChildItems')
				->withCount('ItemDetailsParent')
				->where('legend', $legend)
				->with(['ItemDetailsParent' => function ($query) {
					$query->withCount('ItemDetailChilds');
				}, 'ItemDetailsParent.ItemDetailChilds', 'Unit', 'ChildItems.ChildItems.ChildItems'])
				->whereNull('parent_id')
				->where('master_phase_slug', $master_phase_slug)
				->get();
		} else {
			$items = Item::
			withCount('ChildItems')
				->withCount('ItemDetailsParent')
				->with(['ItemDetailsParent' => function ($query) {
					$query->withCount('ItemDetailChilds');
				}, 'ItemDetailsParent.ItemDetailChilds', 'Unit', 'ChildItems.ChildItems.ChildItems'])
				->whereNull('parent_id')
				->where('master_phase_slug', $master_phase_slug)
				->get();
		}

		$shotedItems = $this->getShortedItemWithChildItems($items);

		$workOrderItems = $workOrder->WorkOrderItems->map(function ($item) {

			$data = [
				'item_id' => $item->item_id,
				'item_no' => $item->item_no,
				'quantity' => $item->quantity,
				'rate' => $item->rate,
				'total_rate' => format_amount($item->quantity * $item->rate)
			];

			foreach ($item->itemDetails as $itemDetail) {

				$data['item_details'][] = [
					'item_detail_id' => $itemDetail->item_detail_id,
					'percentage' => $itemDetail->percentage,
					'due_amount' => format_amount(($item->quantity * $item->rate * $itemDetail->percentage) / 100)
				];
			}
			return $data;
		});
		$workOrderItems = $workOrderItems->toArray();
		$legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $master_phase_slug)->get();
		$workOrder_id = $workOrder->id;

		return view('workorders.link-items', compact('workOrder', 'title', 'breadcrumb', 'items', 'workOrderItems', 'shotedItems','legends','requested_legend','workOrder_id'));
	}
}
