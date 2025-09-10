<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Checkout;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssetTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.com'],
            ['name' => 'John Smith', 'email' => 'john@example.com'],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah@example.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'),
                ]
            );
        }

        // Create sample locations
        $locations = [
            [
                'location_id' => 'LOC-001',
                'location' => 'Main Tool Room',
                'bin' => 'Shelf A1',
                'description' => 'Primary storage for hand tools and small equipment',
            ],
            [
                'location_id' => 'LOC-002',
                'location' => 'Maintenance Shed',
                'bin' => 'Toolbox 1',
                'description' => 'Outdoor storage for larger tools and equipment',
            ],
            [
                'location_id' => 'LOC-003',
                'location' => 'Garden Storage',
                'bin' => 'Bin 3',
                'description' => 'Storage for gardening tools and supplies',
            ],
            [
                'location_id' => 'LOC-004',
                'location' => 'Construction Site',
                'bin' => 'Trailer',
                'description' => 'Mobile storage for construction equipment',
            ],
        ];

        foreach ($locations as $locationData) {
            Location::firstOrCreate(
                ['location_id' => $locationData['location_id']],
                $locationData
            );
        }

        // Create sample assets
        $assets = [
            [
                'asset_id' => 'TOOL-001',
                'item' => 'Shovel',
                'item_code' => 'SHOVEL-001',
                'belongs_to' => 'Maintenance',
                'condition' => 'Good',
                'comments' => 'Standard garden shovel, well maintained',
                'location_id' => Location::where('location_id', 'LOC-001')->first()->id,
            ],
            [
                'asset_id' => 'TOOL-002',
                'item' => 'Power Drill',
                'item_code' => 'DRILL-001',
                'belongs_to' => 'Maintenance',
                'condition' => 'Excellent',
                'comments' => 'Cordless drill with multiple bits included',
                'location_id' => Location::where('location_id', 'LOC-001')->first()->id,
            ],
            [
                'asset_id' => 'TOOL-003',
                'item' => 'Ladder',
                'item_code' => 'LADDER-001',
                'belongs_to' => 'Maintenance',
                'condition' => 'Fair',
                'comments' => '8-foot aluminum ladder, some wear on steps',
                'location_id' => Location::where('location_id', 'LOC-002')->first()->id,
            ],
            [
                'asset_id' => 'TOOL-004',
                'item' => 'Hedge Trimmer',
                'item_code' => 'HEDGE-001',
                'belongs_to' => 'Garden',
                'condition' => 'Good',
                'comments' => 'Electric hedge trimmer for garden maintenance',
                'location_id' => Location::where('location_id', 'LOC-003')->first()->id,
            ],
            [
                'asset_id' => 'TOOL-005',
                'item' => 'Hammer',
                'item_code' => 'HAMMER-001',
                'belongs_to' => 'Construction',
                'condition' => 'Worn',
                'comments' => 'Heavy-duty hammer, handle shows wear',
                'location_id' => Location::where('location_id', 'LOC-004')->first()->id,
            ],
            [
                'asset_id' => 'TOOL-006',
                'item' => 'Screwdriver Set',
                'item_code' => 'SCREW-001',
                'belongs_to' => 'Maintenance',
                'condition' => 'Excellent',
                'comments' => 'Complete set of Phillips and flathead screwdrivers',
                'location_id' => Location::where('location_id', 'LOC-001')->first()->id,
            ],
        ];

        foreach ($assets as $assetData) {
            Asset::firstOrCreate(
                ['asset_id' => $assetData['asset_id']],
                $assetData
            );
        }

        // Create sample checkouts
        $checkouts = [
            [
                'checkout_id' => 'CHK-001',
                'asset_id' => Asset::where('asset_id', 'TOOL-001')->first()->id,
                'user_id' => User::where('email', 'john@example.com')->first()->id,
                'date_checked_out' => now()->subDays(3),
                'checked_out_by' => 'John Smith',
                'date_returned' => now()->subDays(1),
                'quantity' => 1,
                'checkout_comments' => 'Used for garden project, returned in good condition',
            ],
            [
                'checkout_id' => 'CHK-002',
                'asset_id' => Asset::where('asset_id', 'TOOL-002')->first()->id,
                'user_id' => User::where('email', 'jane@example.com')->first()->id,
                'date_checked_out' => now()->subDays(1),
                'checked_out_by' => 'Jane Doe',
                'date_returned' => null, // Still out
                'quantity' => 1,
                'checkout_comments' => 'Emergency repair work, will return tomorrow',
            ],
            [
                'checkout_id' => 'CHK-003',
                'asset_id' => Asset::where('asset_id', 'TOOL-003')->first()->id,
                'user_id' => User::where('email', 'mike@example.com')->first()->id,
                'date_checked_out' => now()->subHours(4),
                'checked_out_by' => 'Mike Johnson',
                'date_returned' => null, // Still out
                'quantity' => 1,
                'checkout_comments' => 'Painting project, needed for high areas',
            ],
            [
                'checkout_id' => 'CHK-004',
                'asset_id' => Asset::where('asset_id', 'TOOL-004')->first()->id,
                'user_id' => User::where('email', 'sarah@example.com')->first()->id,
                'date_checked_out' => now()->subDays(5),
                'checked_out_by' => 'Sarah Wilson',
                'date_returned' => now()->subDays(2),
                'quantity' => 1,
                'checkout_comments' => 'Garden maintenance, hedge trimming completed',
            ],
        ];

        foreach ($checkouts as $checkoutData) {
            Checkout::firstOrCreate(
                ['checkout_id' => $checkoutData['checkout_id']],
                $checkoutData
            );
        }
    }
}