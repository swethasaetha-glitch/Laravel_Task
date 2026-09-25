<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FabricController;
use App\Http\Controllers\FabricGroupController;
use App\Http\Controllers\FabricInspectionController;
use App\Http\Controllers\FabricProcurementController;
use App\Http\Controllers\LayModelController;
use App\Http\Controllers\LaySlipController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProductionPlanController;
use App\Http\Controllers\TrackTechAppController;
use Illuminate\Support\Facades\Route;

// Guest Routes (Login & Sign Up)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/app-test', [TrackTechAppController::class, 'index'])->name('app-test.index');

    // Stage 1 & 2: Buyer Orders & Sales Orders (ERP Entry)
    Route::get('/buyer-orders', [OrderController::class, 'buyerOrders'])->name('buyer-orders.index');
    Route::post('/buyer-orders', [OrderController::class, 'storeBuyerOrder'])->name('buyer-orders.store');
    Route::get('/sales-orders', [OrderController::class, 'salesOrders'])->name('sales-orders.index');
    Route::post('/sales-orders', [OrderController::class, 'storeSalesOrder'])->name('sales-orders.store');

    // Stage 3: Production Planning
    Route::get('/production-plans', [ProductionPlanController::class, 'index'])->name('production-plans.index');
    Route::post('/production-plans', [ProductionPlanController::class, 'store'])->name('production-plans.store');

    // Stage 4 & 5: Fabric Procurement & Goods Receipt Note (GRN)
    Route::get('/fabric-pos', [FabricProcurementController::class, 'pos'])->name('fabric-pos.index');
    Route::post('/fabric-pos', [FabricProcurementController::class, 'storePo'])->name('fabric-pos.store');
    Route::get('/fabric-grns', [FabricProcurementController::class, 'grns'])->name('fabric-grns.index');
    Route::post('/fabric-grns', [FabricProcurementController::class, 'storeGrn'])->name('fabric-grns.store');

    // Stage 6 & 7: 4-Point Fabric Inspection & Relaxation
    Route::get('/fabric-inspections', [FabricInspectionController::class, 'inspectionIndex'])->name('fabric-inspections.index');
    Route::post('/fabric-inspections', [FabricInspectionController::class, 'storeInspection'])->name('fabric-inspections.store');
    Route::get('/fabric-relaxations', [FabricInspectionController::class, 'relaxationIndex'])->name('fabric-relaxations.index');
    Route::post('/fabric-relaxations', [FabricInspectionController::class, 'storeRelaxation'])->name('fabric-relaxations.store');

    // Fabric Master & Fabric Groups
    Route::resource('fabrics', FabricController::class);
    Route::get('/fabric-groups/{fabricGroup}/fabrics', [FabricGroupController::class, 'getFabrics'])->name('fabric-groups.get-fabrics');
    Route::post('/fabric-groups/{fabricGroup}/add-fabrics', [FabricGroupController::class, 'addFabrics'])->name('fabric-groups.add-fabrics');
    Route::delete('/fabric-groups/{fabricGroup}/fabrics/{fabric}', [FabricGroupController::class, 'removeFabric'])->name('fabric-groups.remove-fabric');
    Route::resource('fabric-groups', FabricGroupController::class);

    // Stage 8: Lay Models & Lay Planning / Lay Slips (Up to Lay Completed)
    Route::resource('lay-models', LayModelController::class);
    Route::get('/lay-slips', [LaySlipController::class, 'index'])->name('lay-slips.index');
    Route::post('/lay-slips', [LaySlipController::class, 'store'])->name('lay-slips.store');

    // Production Modules
    Route::get('/production/bundles', [ProductionController::class, 'bundles'])->name('production.bundles');
    Route::post('/production/bundles', [ProductionController::class, 'storeBundle'])->name('production.bundles.store');
    Route::delete('/production/bundles/{bundle}', [ProductionController::class, 'destroyBundle'])->name('production.bundles.destroy');
    Route::get('/production/cutting', [ProductionController::class, 'cutting'])->name('production.cutting');
    Route::get('/production/sewing', [ProductionController::class, 'sewing'])->name('production.sewing');
    Route::get('/production/quality', [ProductionController::class, 'quality'])->name('production.quality');
    Route::get('/production/packing', [ProductionController::class, 'packing'])->name('production.packing');

    // Garment Masters & Process Sequences
    Route::get('/masters', [\App\Http\Controllers\MasterController::class, 'index'])->name('masters.index');
    Route::post('/masters/styles', [\App\Http\Controllers\MasterController::class, 'storeStyle'])->name('masters.styles.store');
    Route::post('/masters/machines', [\App\Http\Controllers\MasterController::class, 'storeMachine'])->name('masters.machines.store');
    Route::post('/masters/operators', [\App\Http\Controllers\MasterController::class, 'storeOperator'])->name('masters.operators.store');
    Route::post('/masters/supervisors', [\App\Http\Controllers\MasterController::class, 'storeSupervisor'])->name('masters.supervisors.store');
    Route::post('/masters/defects', [\App\Http\Controllers\MasterController::class, 'storeDefect'])->name('masters.defects.store');
    Route::post('/masters/shades', [\App\Http\Controllers\MasterController::class, 'storeShade'])->name('masters.shades.store');

    // Cut Room Planning & Settings
    Route::get('/cut-planning', [\App\Http\Controllers\CutRoomPlannerController::class, 'index'])->name('cut-planning.index');
    Route::post('/cut-planning', [\App\Http\Controllers\CutRoomPlannerController::class, 'store'])->name('cut-planning.store');

    // Department-Wise & Machine-Wise Live Dashboard
    Route::get('/department-dashboard', [\App\Http\Controllers\DepartmentDashboardController::class, 'index'])->name('department-dashboard.index');
});

