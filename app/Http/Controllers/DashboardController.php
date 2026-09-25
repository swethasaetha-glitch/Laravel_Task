<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFabrics = Fabric::count();
        $totalFabricGroups = FabricGroup::count();
        $totalLayModels = LayModel::count();

        return view('dashboard', compact('totalFabrics', 'totalFabricGroups', 'totalLayModels'));
    }
}
