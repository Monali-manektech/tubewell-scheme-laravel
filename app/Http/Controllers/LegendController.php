<?php

namespace App\Http\Controllers;

use App\Models\Legend;
use Illuminate\Http\Request;
use App\Http\Requests\LegendRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\Helper;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use App\Models\WorkOrderItems;

class LegendController extends Controller
{
    use Helper;

    public function index(Request $request, $master_phase_slug)
    {
        if($request->ajax()){
            $legend = Legend::whereNull('deleted_at')->where('master_phase_slug', $master_phase_slug)->get();
            return DataTables::of($legend)
                    ->addIndexColumn()
                    ->editColumn('name',function ($data){
                        return $data->name ? $data->name : null;
                    })
                    ->addColumn('action',function ($data){
                        return view('legend._form_actions', compact('data'))->render();
                    })
                    ->make();
        }

        return view('legend.index', compact('master_phase_slug'));
    }


    public function create($master_phase_slug)
    {
        return view('legend.add', compact('master_phase_slug'));
    }


    public function show(Legend $legend, $master_phase_slug)
    {
        //
    }


    public function edit($master_phase_slug, $id)
    {
		$legend = Legend::find($id);
        return view('legend.edit',compact('master_phase_slug', 'legend'));
    }


    public function update(Request $request, $master_phase_slug, $id)
    {
        //
    }



	public function destroy($master_phase_slug, $id)
    {
		$legend = Legend::find($id);
        $legend->delete();
        Session::flash('success', 'Legend deleted successfully.');

        return redirect()->route('legend.index', $master_phase_slug);
    }

    public function changeLegendNameToId()
    {
        $items = Item::select('id','legend')->orderBy('id','asc')->get();
        foreach($items as $item){
            $legend = Legend::where('name', $item->legend)->first();
            if($legend){
                Item::where('id', $item->id)->update(['legend' => $legend->id]);
            }
        }

        $WorkOrderItems = WorkOrderItems::select('id','legend')->orderBy('id','asc')->get();
        foreach($WorkOrderItems as $WorkOrderItem){
            $legend = Legend::where('name', $WorkOrderItem->legend)->first();
            if($legend){
                WorkOrderItems::where('id', $WorkOrderItem->id)->update(['legend' => $legend->id]);
            }
        }
        return true;
    }
}
