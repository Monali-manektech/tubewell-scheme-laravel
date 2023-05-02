<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{

    public function index(Request $request, $master_phase_slug)
    {
        $title = "Unit";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Units",
            ],
        ];

        if($request->ajax()){
            $units = Unit::query()->where('master_phase_slug', $master_phase_slug);
            return DataTables::of($units)
                    ->addIndexColumn()
                    ->addColumn('action',function ($data){
                        return view('units._form_actions', compact('data'))->render();
                    })
                    ->make();
        }

        return view('units.index', compact('title', 'breadcrumb', 'master_phase_slug'));
    }

    public function create($master_phase_slug)
    {
        $title = "Add Unit";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Units",
                'link' => route('units.create', $master_phase_slug)
            ],
            [
                'title' => "Add Unit",
            ],
        ];

        return view('units.create', compact('title', 'breadcrumb', 'master_phase_slug'));
    }

    public function edit($master_phase_slug, $id)
    {
        $title = "Edit Unit";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Units",
                'link' => route('units.index', $master_phase_slug)
            ],
            [
                'title' => "Edit Unit",
            ],
        ];

		$unit = Unit::find($id);
        return view('units.edit', compact('title', 'breadcrumb', 'unit', 'master_phase_slug'));
    }


    public function destroy($master_phase_slug, $id)
    {
		$unit = Unit::find($id);
        $unit->delete();
        Session::flash('success', 'Unit deleted successfully.');
		return redirect()->back();
    }
}
