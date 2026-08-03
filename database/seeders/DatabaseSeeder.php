<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WasteRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with sample data for demo purposes.
     */
    public function run(): void
    {
        // Fixed demo accounts (password for all: "password")
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@ecolink.test',
        ]);

        $citizen = User::factory()->citizen()->create([
            'name' => 'Ahmed Citizen',
            'email' => 'citizen@ecolink.test',
        ]);

        $collector = User::factory()->collector()->create([
            'name' => 'Bilal Collector',
            'email' => 'collector@ecolink.test',
        ]);

        // Additional random users
        $citizens = User::factory(8)->citizen()->create();
        $collectors = User::factory(4)->collector()->create();

        $allCitizens = $citizens->push($citizen);
        $allCollectors = $collectors->push($collector);

        // Pending requests (unassigned) from various citizens
        WasteRequest::factory(12)
            ->recycle($allCitizens)
            ->create();

        // Accepted (in-progress) requests
        WasteRequest::factory(6)
            ->recycle($allCitizens)
            ->recycle($allCollectors)
            ->accepted()
            ->create();

        // Collected (completed) requests
        WasteRequest::factory(8)
            ->recycle($allCitizens)
            ->recycle($allCollectors)
            ->collected()
            ->create();

        // A few cancelled requests
        WasteRequest::factory(3)
            ->recycle($allCitizens)
            ->cancelled()
            ->create();

        // A couple of guaranteed requests for the fixed demo citizen
        WasteRequest::factory()->create([
            'user_id' => $citizen->id,
            'type' => 'Plastic',
            'weight' => 5.5,
            'address' => 'House 12, Block 4, Gulshan-e-Iqbal, Karachi',
            'description' => 'Two large bags of plastic bottles and containers.',
            'status' => 'Pending',
        ]);

        WasteRequest::factory()->create([
            'user_id' => $citizen->id,
            'collector_id' => $collector->id,
            'type' => 'E-waste',
            'weight' => 3,
            'address' => 'Flat 3B, Clifton Block 5, Karachi',
            'description' => 'Old laptop, keyboard, and a broken monitor.',
            'status' => 'Accepted',
            'accepted_at' => now()->subHours(3),
        ]);
    }
}
