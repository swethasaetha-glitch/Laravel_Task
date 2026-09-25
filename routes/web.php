<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FabricController;
use App\Http\Controllers\FabricGroupController;
use App\Http\Controllers\LayModelController;
use App\Http\Controllers\ProductionController;
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

    Route::get('/production/bundles', [ProductionController::class, 'bundles'])->name('production.bundles');
    Route::post('/production/bundles', [ProductionController::class, 'storeBundle'])->name('production.bundles.store');
    Route::delete('/production/bundles/{bundle}', [ProductionController::class, 'destroyBundle'])->name('production.bundles.destroy');
    Route::get('/production/cutting', [ProductionController::class, 'cutting'])->name('production.cutting');
    Route::get('/production/sewing', [ProductionController::class, 'sewing'])->name('production.sewing');
    Route::get('/production/quality', [ProductionController::class, 'quality'])->name('production.quality');
    Route::get('/production/packing', [ProductionController::class, 'packing'])->name('production.packing');

    // Fabric Master CRUD
    Route::resource('fabrics', FabricController::class);

    // Fabric Group CRUD & Management
    Route::get('/fabric-groups/{fabricGroup}/fabrics', [FabricGroupController::class, 'getFabrics'])->name('fabric-groups.get-fabrics');
    Route::post('/fabric-groups/{fabricGroup}/add-fabrics', [FabricGroupController::class, 'addFabrics'])->name('fabric-groups.add-fabrics');
    Route::delete('/fabric-groups/{fabricGroup}/fabrics/{fabric}', [FabricGroupController::class, 'removeFabric'])->name('fabric-groups.remove-fabric');
    Route::resource('fabric-groups', FabricGroupController::class);

    // Lay Model CRUD
    Route::resource('lay-models', LayModelController::class);
});
