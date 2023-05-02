<?php

namespace App\Http\Controllers;

use App\Imports\ImportItem;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Models\WorkOrderItems;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Str;
use App\Models\Legend;

class ItemController extends Controller
{
    use Helper;

    public function index(Request $request, $master_phase_slug, $item_id = null)
    {
        $item = null;
        $title = "Item";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Item",
                'link' => route('items.index', $master_phase_slug),
            ],
        ];


        if($item_id){
            $title = 'Sub Item';
            array_push($breadcrumb, ['title' => "Sub Item",]);
            $item = Item::where('id', $item_id)->first();
        }

        if($request->ajax()){
            $items = Item::query()->where('master_phase_slug', $master_phase_slug)->with(['Unit', 'itemChild'])->withCount('ChildItems');

            if($item_id){
                $items = $items->where('parent_id', $item_id);
            }else{
                $items = $items->whereNull('parent_id');
            }
            if($request->input('order')[0]['column'] == "0") {
                $items = $items->orderBy('id', 'asc');
            }
            return DataTables::of($items)
                    ->addIndexColumn()
                    ->editColumn('legend',function ($data){
                        $legend_name = Legend::where('id', $data->legend)->whereNull('deleted_at')->first();
                        return $legend_name->name ? $legend_name->name : null;
                    })
                    ->editColumn('units',function ($data){
                        return $data->Unit ? $data->Unit->name : null;
                    })
                    ->editColumn('rate',function ($data){
                        return $this->formatAmount($data->rate);
                    })
                    ->editColumn('description', function ($data){
                        return Str::limit($data->description, 120);
                    })
                    ->addColumn('subitem_count', function ($data){
                        return $data->child_items_count;
                    })
                    ->addColumn('action',function ($data){
                        return view('items._form_actions', compact('data'))->render();
                    })
                    ->make();
        }
        $legends = Legend::whereNull('deleted_at')->where('master_phase_slug', $master_phase_slug)->get();
        return view('items.index', compact('title', 'breadcrumb', 'item_id', 'item','legends', 'master_phase_slug'));
    }

    public function create($master_phase_slug, $parent_id = null)
    {
        $title = "Add Item";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Item",
                'link' => route('items.index', $master_phase_slug),
            ],
            [
                'title' => "Add Item",
            ],
        ];

        return view('items.create', compact('title', 'breadcrumb', 'parent_id', 'master_phase_slug'));
    }

    public function edit($master_phase_slug, $id)
    {
		$item = Item::find($id);
        $title = "Edit Item";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Item",
                'link' => route('items.index', $master_phase_slug),
            ],
            [
                'title' => "Edit Item",
            ],
        ];
        return view('items.edit', compact('title', 'breadcrumb', 'item', 'master_phase_slug'));
    }

    public function show($master_phase_slug, $id)
    {
		$item = Item::find($id);
        $title = "Sub Items";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Item",
                'link' => route('admin.items', $master_phase_slug),
            ],
            [
                'title' => "Sub Item",
            ],
        ];
    }

    public function destroy($master_phase_slug, $id)
    {
		$item = Item::find($id);
        Item::where('parent_id', $id)->where('master_phase_slug', $master_phase_slug)->delete();
    	ItemDetail::where('item_id', $id)->where('master_phase_slug', $master_phase_slug)->delete();

        $item->delete();
        Session::flash('success', 'Item deleted successfully.');

        return redirect()->route('items.index', $master_phase_slug);
    }

    public function importExcel(Request $request)
    {
        $rows = Excel::import(new ImportItem, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function filterItemThroughLegend(Request $request, $legend = null)
    {
        $item_id = null;
        if($request->ajax()){
            if($legend){
                $items = Item::where('legend', $legend)->with(['Unit', 'itemChild'])->withCount('ChildItems');
            }else{
                $items = Item::query()->with(['Unit', 'itemChild'])->withCount('ChildItems');
            }

            if($item_id){
                $items = $items->where('parent_id', $item_id);
            }else{
                $items = $items->whereNull('parent_id');
            }
            if($request->input('order')[0]['column'] == "0") {
                $items = $items->orderBy('id', 'asc');
            }
            return DataTables::of($items)
            ->addIndexColumn()
            ->editColumn('legend',function ($data){
                $legend = Legend::where('id', $data->legend)->whereNull('deleted_at')->first();
                return $legend->name ? $legend->name : null;
            })
            ->editColumn('units',function ($data){
                return $data->Unit ? $data->Unit->name : null;
            })
            ->editColumn('rate',function ($data){
                return $this->formatAmount($data->rate);
            })
            ->editColumn('description', function ($data){
                return Str::limit($data->description, 120);
            })
            ->addColumn('subitem_count', function ($data){
                return $data->child_items_count;
            })
            ->addColumn('action',function ($data){
                return view('items._form_actions', compact('data'))->render();
            })
            ->make();
        }
    }

	public function addPaymentBreakup()
	{

		try {
			$items_54 = Item::query()->with('itemChild')->where('parent_id', 54)->get()->toArray();

			foreach ($items_54 as $item_54) {


					$itemDetails = ItemDetail::
					where(['item_id' => 54, 'parent_id' => null])
						->with(['ItemDetailChilds' => function ($query) {
							return $query->orderBy('created_at');
						}])
						->orderBy('created_at')
						->get();

					$itemDetails = collect($itemDetails)->toArray();

					foreach ($itemDetails as $value) {

						if (!empty($value['percentage'])) {

							$itemArray = $this->itemDetailArray($value, $item_54['id']);
							$item_response = $this->storeData($itemArray, null);

							if (isset($value['item_detail_childs']) && count($value['item_detail_childs']) > 0) {
								foreach ($value['item_detail_childs'] as $item_detail_child) {

									if (isset($item_detail_child['name']) && isset($item_detail_child['percentage']) && $item_detail_child['percentage'] != '') {
										$itemChildArray = $this->itemDetailArray($item_detail_child, $item_54['id'], $item_response->id);
										$this->storeData($itemChildArray, null);
									}

								}
							}
						}
					}

					foreach ($item_54['item_child'] as $item_54_child) {

						foreach ($itemDetails as $value) {

							if (!empty($value['percentage'])) {

								$itemArray = $this->itemDetailArray($value, $item_54_child['id']);
								$item_response = $this->storeData($itemArray, null);

								if (isset($value['item_detail_childs']) && count($value['item_detail_childs']) > 0) {
									foreach ($value['item_detail_childs'] as $item_detail_child) {

										if (isset($item_detail_child['name']) && isset($item_detail_child['percentage']) && $item_detail_child['percentage'] != '') {
											$itemChildArray = $this->itemDetailArray($item_detail_child, $item_54_child['id'], $item_response->id);
											$this->storeData($itemChildArray, null);
										}

									}
								}
							}
						}
					}
			}

			dd('done');
		} catch (\Exception $e) {
			dd($e->getMessage(). $e->getFile(). $e->getLine());
		}

	}

	private function itemDetailArray($itemDetails , $itemID, $parentID = null) {
		return [
			'name' => $itemDetails['name'] ?? '',
			'percentage' => $itemDetails['percentage'] ?? '',
			'parent_id' => $parentID,
			'item_id' => $itemID
		];
	}

	private function storeData($array , $id = null) {
		return ItemDetail::updateOrCreate(['id' => $id], $array);
	}

	public function applyItemOrder()
	{
		try {

			$main_items = Item::query()->with('itemChild')->where('parent_id', null)->get();

			foreach ($main_items as $main_item) {

				$main_item->update(['item_order' => $main_item->item_no]);
				$count = 1;
				foreach ($main_item->itemChild as $item) {

					if (str_contains(' Additional Item ', $item->item_no) || str_contains(' J ', $item->item_no)) {

						$data = Item::find($item->parent_id);
						if ($data) {
							$item_no = strlen($count) > 1 ? (int)$data->item_no . '.' . $count : (int)$data->item_no . '.0' . $count;
							$item->update(['item_order' => $item_no]);
							$count++;
						}

					} else {
						$item->update(['item_order' => $item->item_no]);
					}

					$sub_count = 1;
					foreach ($item->itemChild as $sub_item) {

						if (str_contains(' Additional Item ', $sub_item->item_no) || str_contains(' J ', $sub_item->item_no)) {
							$sub_item_no = strlen($sub_count) > 1 ? $item->item_order . '.' . $sub_count : $item->item_order . '.0' . $sub_count;
							$sub_item->update(['item_order' => $sub_item_no]);
							$sub_count++;
						} else {
							$sub_item->update(['item_order' => $sub_item->item_no]);
						}
					}
				}
			}

			$work_orders = WorkOrderItems::get();
			foreach ($work_orders as $work_order) {

                $item = Item::find($work_order->item_id);
				$work_order->update(['item_order' => $item->item_order]);
			}

			dd('done');
		} catch (\Exception $e) {
			dd($e->getMessage(). $e->getFile(). $e->getLine());
		}

	}
}
