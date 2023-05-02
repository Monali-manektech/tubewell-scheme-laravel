<?php

namespace App\Http\Controllers;

use App\Models\Grampanchayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class GrampanchayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $master_phase_slug)
    {
        $title = "Gram Panchayat";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Gram Panchayat",
            ],
        ];

        if($request->ajax()) {
            $grampanchayats = Grampanchayat::query()->where('master_phase_slug', $master_phase_slug);

            return DataTables::of($grampanchayats)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                return view('grampanchayats._form_actions', compact('data'))->render();
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('grampanchayats.index', compact('title', 'breadcrumb', 'master_phase_slug'));
    }

    public function create($master_phase_slug)
    {
        $title = "Add Gram Panchayat";
        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Gram Panchayat",
                'link' => route('gram-panchayats.index', $master_phase_slug),
            ],
            [
                'title' => "Add Gram Panchayat",
            ],
        ];

        return view('grampanchayats.create', compact('title', 'breadcrumb', 'master_phase_slug'));
    }

    public function edit($master_phase_slug, $id)
    {
		$gram_panchayat = Grampanchayat::find($id);
        $title = "Edit Gram Panchayat";

        $breadcrumb = [
            [
                'title' => "Dashboard",
                'link' => route('admin.dashboard'),
            ],
            [
                'title' => "Gram Panchayat",
                'link' => route('gram-panchayats.index', $master_phase_slug),
            ],
            [
                'title' => "Add Gram Panchayat",
            ],
        ];

        $grampanchayat = $gram_panchayat;
        return view('grampanchayats.edit', compact('grampanchayat', 'breadcrumb', 'title', 'master_phase_slug'));
    }

    public function destroy($master_phase_slug, $id)
    {
		$gram_panchayat = Grampanchayat::find($id);
        $gram_panchayat->delete();
        Session::flash('success', 'Grampanchayat deleted successfully.');

        return redirect()->route('gram-panchayats.index', $master_phase_slug);
    }
}
