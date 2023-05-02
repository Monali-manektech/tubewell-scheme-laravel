<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrampanchayatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RAController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\LegendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false
]);

Route::group(['prefix'=>'admin','middleware' => 'auth'], function() {

	Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
	Route::get('profile', [DashboardController::class, 'profile'])->name('admin.profile');
	Route::get('sort/items', [HomeController::class, 'sortItems']);

	Route::resource('work-orders', WorkOrderController::class);
    Route::get('work-orders/link-items/{work_order}', [WorkOrderController::class, 'linkItems'])->name('work-orders.linkItems');
    Route::put('work-orders/link-items/{work_order}', [WorkOrderController::class, 'storeLinkItems'])->name('work-orders.StoreLinkItems');
    Route::get('filter-link-items-through-legend/{legend?}', [WorkOrderController::class, 'filterLinkItemThroughLegend'])->name('link.items.filter.legend');
	Route::get('work-orders/link-ra/{work_order}/{ra?}', [WorkOrderController::class, 'linkRaDetails'])->name('work-orders.linkRaDetails');
    Route::post('work-orders/link-ra/{work_order}', [WorkOrderController::class, 'storeLinkRaDetails'])->name('work-orders.StoreLinkRaDetails');
	Route::get('filter-RA-through-legend', [WorkOrderController::class, 'filterRAThroughLegend'])->name('ra.filter.legend');

	Route::resource('ra', RAController::class)->except(['index', 'show']);
	Route::get('ra/{work_order?}', [RAController::class, 'index'])->name('ra.index');

    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::any('report/get-report/{work_order?}', [ReportController::class, 'export'])->name('report.export');
    Route::any('filter-report-through-legend', [ReportController::class, 'filterReportThroughLegend'])->name('report.filter.legend');


	Route::group(['prefix'=>'{master_phase_slug}/gram-panchayats'], function() {
		Route::get('/', [GrampanchayatController::class, 'index'])->name('gram-panchayats.index');
		Route::get('/create', [GrampanchayatController::class, 'create'])->name('gram-panchayats.create');
		Route::post('/', [GrampanchayatController::class, 'store'])->name('gram-panchayats.store');
		Route::get('/edit/{id}', [GrampanchayatController::class, 'edit'])->name('gram-panchayats.edit');
		Route::post('/{id}', [GrampanchayatController::class, 'update'])->name('gram-panchayats.update');
		Route::get('/destroy/{id}', [GrampanchayatController::class, 'destroy'])->name('gram-panchayats.destroy');
	});

	Route::group(['prefix'=>'{master_phase_slug}/items'], function() {
		Route::get('/create/{id?}', [ItemController::class, 'create'])->name('items.create.subitem');
		Route::get('/{id?}', [ItemController::class, 'index'])->name('items.index');
		Route::get('/create', [ItemController::class, 'create'])->name('items.create');
		Route::post('/', [ItemController::class, 'store'])->name('items.store');
		Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
		Route::post('/{id}', [ItemController::class, 'update'])->name('items.update');
		Route::get('/destroy/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
	});

	Route::get('filter-items-through-legend/{legend?}', [ItemController::class, 'filterItemThroughLegend'])->name('items.filter.legend');


	Route::group(['prefix'=>'{master_phase_slug}/units'], function() {
		Route::get('/', [UnitController::class, 'index'])->name('units.index');
		Route::get('/create', [UnitController::class, 'create'])->name('units.create');
		Route::post('/', [UnitController::class, 'store'])->name('units.store');
		Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('units.edit');
		Route::post('/{id}', [UnitController::class, 'update'])->name('units.update');
		Route::get('/destroy/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
	});


	Route::group(['prefix'=>'{master_phase_slug}/legend'], function() {
		Route::get('/', [LegendController::class, 'index'])->name('legend.index');
		Route::get('/create', [LegendController::class, 'create'])->name('legend.create');
		Route::post('/', [LegendController::class, 'store'])->name('legend.store');
		Route::get('/edit/{id}', [LegendController::class, 'edit'])->name('legend.edit');
		Route::post('/{id}', [LegendController::class, 'update'])->name('legend.update');
		Route::get('/destroy/{id}', [LegendController::class, 'destroy'])->name('legend.destroy');
	});




	// Route::get('change-legend-name-to-id', [LegendController::class, 'changeLegendNameToId']);
    // Route::get('add-payment-breakup', [ItemController::class, 'addPaymentBreakup']);
    //  Route::get('apply-item-order', [ItemController::class, 'applyItemOrder']);
});
