<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MultitenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tenant::create([
            'name' => 'Laravel Tenant2',
            'domain' => 'laravel-multitenant1.local',
            'database' => 'laravel_multitenant_tenant1',
        ]);

        \App\Models\Tenant::create([
            'name' => 'Laravel Tenant1',
            'domain' => 'laravel-multitenant2.local',
            'database' => 'laravel_multitenant_tenant2',
        ]);
    }
}
