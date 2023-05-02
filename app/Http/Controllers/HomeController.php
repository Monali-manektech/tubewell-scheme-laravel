<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sortItems()
    {
        $items = Item::
                    withCount('ChildItems')
                    ->withCount('ItemDetailsParent')
                    ->with(['ItemDetailsParent' => function ($query) {
                        $query->withCount('ItemDetailChilds');
                    }, 'ItemDetailsParent.ItemDetailChilds', 'Unit', 'ChildItems.ChildItems.ChildItems'])
                    ->whereNull('parent_id')
                    ->get();
        return view('layouts.admin.sort_items', compact('items'));
    }
}
