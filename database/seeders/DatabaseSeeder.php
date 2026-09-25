<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('ChangeMe@123'),
                'role' => 'Admin',
            ]
        );

        // 2. Fabrics
        $fab1 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-001'],
            [
                'fabric_name' => 'Cotton Single Jersey',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color' => 'Black',
                'gsm' => 180,
                'width' => 72,
                'unit' => 'KG',
                'description' => 'Single jersey knitted fabric for t-shirts.',
                'status' => 'Active',
            ]
        );

        $fab2 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-002'],
            [
                'fabric_name' => 'Cotton Rib',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color' => 'White',
                'gsm' => 220,
                'width' => 68,
                'unit' => 'KG',
                'description' => 'Rib knitted fabric for collars and cuffs.',
                'status' => 'Active',
            ]
        );

        $fab3 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-003'],
            [
                'fabric_name' => 'Cotton Interlock',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color' => 'Navy',
                'gsm' => 200,
                'width' => 70,
                'unit' => 'KG',
                'description' => 'Double knit interlock fabric.',
                'status' => 'Active',
            ]
        );

        $fab4 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-004'],
            [
                'fabric_name' => 'Polyester',
                'fabric_type' => 'Woven',
                'composition' => '100% Polyester',
                'color' => 'Blue',
                'gsm' => 150,
                'width' => 60,
                'unit' => 'Meter',
                'description' => 'Lightweight synthetic polyester fabric.',
                'status' => 'Active',
            ]
        );

        $fab5 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-005'],
            [
                'fabric_name' => 'Polyester Spandex',
                'fabric_type' => 'Knitted',
                'composition' => '95% Poly 5% Spandex',
                'color' => 'Grey',
                'gsm' => 210,
                'width' => 64,
                'unit' => 'KG',
                'description' => 'Stretch synthetic activewear fabric.',
                'status' => 'Active',
            ]
        );

        // 3. Fabric Groups & Relationships
        $group1 = FabricGroup::updateOrCreate(
            ['group_code' => 'FG-001'],
            [
                'group_name' => 'Cotton Knitted Fabrics',
                'description' => 'All cotton knitted fabrics for garment production.',
                'status' => 'Active',
            ]
        );
        $group1->fabrics()->sync([$fab1->id, $fab2->id, $fab3->id]);

        $group2 = FabricGroup::updateOrCreate(
            ['group_code' => 'FG-002'],
            [
                'group_name' => 'Synthetic Fabrics',
                'description' => 'Synthetic and blended fabrics.',
                'status' => 'Active',
            ]
        );
        $group2->fabrics()->sync([$fab4->id, $fab5->id]);

        // 4. Lay Models
        LayModel::updateOrCreate(
            ['lay_model_code' => 'LM-001'],
            [
                'lay_model_name' => "Men's T-Shirt Lay",
                'fabric_group_id' => $group1->id,
                'fabric_id' => $fab1->id,
                'lay_length' => 12.50,
                'lay_width' => 72.00,
                'number_of_plies' => 50,
                'garment_size' => 'L',
                'marker_length' => 11.80,
                'marker_width' => 68.00,
                'description' => "Standard lay for men's basic t-shirt cutting.",
                'status' => 'Active',
            ]
        );

        LayModel::updateOrCreate(
            ['lay_model_code' => 'LM-002'],
            [
                'lay_model_name' => "Men's Polo Lay",
                'fabric_group_id' => $group1->id,
                'fabric_id' => $fab2->id,
                'lay_length' => 14.00,
                'lay_width' => 68.00,
                'number_of_plies' => 40,
                'garment_size' => 'M',
                'marker_length' => 13.20,
                'marker_width' => 65.00,
                'description' => "Lay model for men's polo shirt collars.",
                'status' => 'Active',
            ]
        );

        // 5. Production Bundles
        \App\Models\ProductionBundle::updateOrCreate(
            ['bundle_no' => 'BND-001'],
            [
                'buyer' => 'Nike',
                'style_no' => 'ST-789',
                'order_no' => 'ORD-101',
                'garment' => "Men's Polo",
                'color' => 'Black',
                'size' => 'L',
                'total_qty' => 1000,
                'completed_qty' => 180,
                'rejected_qty' => 0,
                'status' => 'Active',
            ]
        );

        \App\Models\ProductionBundle::updateOrCreate(
            ['bundle_no' => 'BND-002'],
            [
                'buyer' => 'Adidas',
                'style_no' => 'ST-456',
                'order_no' => 'ORD-102',
                'garment' => 'T-Shirt',
                'color' => 'White',
                'size' => 'M',
                'total_qty' => 1010,
                'completed_qty' => 0,
                'rejected_qty' => 0,
                'status' => 'Active',
            ]
        );
    }
}
